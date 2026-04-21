<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Client\CategoryController as ClientCategoryController;
use App\Http\Controllers\Client\BookingController as ClientBookingController;
use App\Http\Controllers\Client\PostController as ClientPostController;
use App\Http\Controllers\Frontend\ProfileController;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Departure;
use App\Models\Post;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class MissingFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_user_detail_page(): void
    {
        $user = User::factory()->create();
        $controller = app(AdminUserController::class);
        $view = $controller->show($user);

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('admin.users.show', $view->name());
        $this->assertTrue($view->getData()['user']->is($user));
    }

    public function test_restore_user_redirects_back_to_admin_users_trash(): void
    {
        $admin = User::factory()->create(['role' => 1]);
        $deletedUser = User::factory()->create();
        $deletedUser->delete();

        $this->actingAs($admin)
            ->post(route('admin.users.restore', $deletedUser->id))
            ->assertRedirect(route('admin.users.trash'));
    }

    public function test_app_layout_has_link_to_bookings_history_for_logged_in_users(): void
    {
        $layout = file_get_contents(resource_path('views/layouts/header.blade.php'));

        $this->assertStringContainsString("route('bookings.history')", $layout);
    }

    public function test_authenticated_user_can_view_profile_page(): void
    {
        $user = User::factory()->create();
        $controller = app(ProfileController::class);

        $this->actingAs($user);
        $view = $controller->edit();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('frontend.profile.edit', $view->name());
    }

    public function test_customer_can_view_and_search_categories(): void
    {
        Category::create([
            'name' => 'Tour Bien',
            'slug' => 'tour-bien',
            'description' => 'Danh muc tour bien',
        ]);

        Category::create([
            'name' => 'Tour Nui',
            'slug' => 'tour-nui',
            'description' => 'Danh muc tour nui',
        ]);

        $controller = app(ClientCategoryController::class);
        $request = Request::create('/categories', 'GET', ['q' => 'Bien']);
        $view = $controller->index($request);
        $categories = $view->getData()['categories'];

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('client.categories.index', $view->name());
        $this->assertCount(1, $categories->items());
        $this->assertSame('Tour Bien', $categories->items()[0]->name);
    }

    public function test_posts_index_supports_search_query(): void
    {
        $author = User::factory()->create();

        Post::create([
            'title' => 'Cam nang du lich Da Nang',
            'slug' => 'cam-nang-du-lich-da-nang',
            'content' => 'Noi dung 1',
            'user_id' => $author->id,
        ]);

        Post::create([
            'title' => 'Cam nang du lich Ha Noi',
            'slug' => 'cam-nang-du-lich-ha-noi',
            'content' => 'Noi dung 2',
            'user_id' => $author->id,
        ]);

        $controller = app(ClientPostController::class);
        $request = Request::create('/posts', 'GET', ['q' => 'Da Nang']);
        $view = $controller->index($request);
        $posts = $view->getData()['posts'];

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('client.posts.index', $view->name());
        $this->assertCount(1, $posts->items());
        $this->assertSame('Cam nang du lich Da Nang', $posts->items()[0]->title);
    }

    public function test_password_reset_request_page_is_available(): void
    {
        $this->assertTrue(Route::has('password.request'));
    }

    public function test_product_store_validates_unique_slug_and_sale_price_boundaries(): void
    {
        $admin = User::factory()->create(['role' => 1]);
        $category = Category::create([
            'name' => 'Tour Trong Nuoc',
            'slug' => 'tour-trong-nuoc',
            'description' => 'Du lich trong nuoc',
        ]);

        Product::create([
            'name' => 'Tour Da Nang',
            'slug' => 'tour-da-nang',
            'price' => 1000000,
            'sale_price' => 900000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);

        $this->actingAs($admin)
            ->from(route('admin.products.create'))
            ->post(route('admin.products.store'), [
                'name' => 'Tour Da Nang',
                'price' => 1000000,
                'sale_price' => 1200000,
                'category_id' => $category->id,
                'description' => 'Mo ta moi',
            ])
            ->assertRedirect(route('admin.products.create'))
            ->assertSessionHasErrors(['slug', 'sale_price']);
    }

    public function test_booking_history_shows_payment_and_order_status(): void
    {
        $user = User::factory()->create();

        $category = Category::create([
            'name' => 'Tour Mien Tay',
            'slug' => 'tour-mien-tay',
            'description' => 'Danh muc tour mien tay',
        ]);

        $product = Product::create([
            'name' => 'Tour Can Tho',
            'slug' => 'tour-can-tho',
            'price' => 1500000,
            'sale_price' => 1200000,
            'category_id' => $category->id,
            'description' => 'Mo ta tour',
        ]);

        Booking::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 2400000,
            'booking_date' => now()->addDays(7)->toDateString(),
            'status' => 'confirmed',
        ]);

        $this->actingAs($user);
        $controller = app(ClientBookingController::class);
        $view = $controller->history();

        $this->assertInstanceOf(View::class, $view);
        $this->assertSame('client.bookings.history', $view->name());
        $this->assertCount(1, $view->getData()['bookings']);
        $layout = file_get_contents(resource_path('views/client/bookings/history.blade.php'));
        $this->assertStringContainsString('Thanh toán chuyển khoản', $layout);
        $this->assertStringContainsString('Trạng Thái', $layout);
    }

    public function test_customer_can_book_available_departure_and_reserve_seats(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Bien',
            'slug' => 'tour-bien-2',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Nha Trang',
            'slug' => 'tour-nha-trang',
            'price' => 2000000,
            'sale_price' => 1500000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(10)->toDateString(),
            'capacity' => 5,
            'booked_seats' => 0,
            'price' => 1800000,
            'status' => 'open',
        ]);

        $response = $this->actingAs($user)
            ->post(route('bookings.store', $product), [
                'departure_id' => $departure->id,
                'quantity' => 2,
                'note' => 'Test',
            ]);

        $booking = Booking::query()
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('departure_id', $departure->id)
            ->latest('id')
            ->firstOrFail();

        $response->assertRedirect(route('bookings.show', $booking));

        $this->assertDatabaseHas('bookings', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'departure_id' => $departure->id,
            'quantity' => 2,
            'unit_price' => 1800000,
            'total_price' => 3600000,
        ]);
        $this->assertDatabaseHas('departures', [
            'id' => $departure->id,
            'booked_seats' => 2,
        ]);
    }

    public function test_customer_cannot_overbook_departure(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Nui 2',
            'slug' => 'tour-nui-2',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Sapa',
            'slug' => 'tour-sapa',
            'price' => 1800000,
            'sale_price' => 1600000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(8)->toDateString(),
            'capacity' => 2,
            'booked_seats' => 2,
            'price' => 1600000,
            'status' => 'open',
        ]);

        $this->actingAs($user)
            ->from(route('products.detail', $product->slug))
            ->post(route('bookings.store', $product), [
                'departure_id' => $departure->id,
                'quantity' => 1,
            ])
            ->assertRedirect(route('products.detail', $product->slug))
            ->assertSessionHasErrors('departure_id');

        $this->assertDatabaseMissing('bookings', [
            'user_id' => $user->id,
            'departure_id' => $departure->id,
        ]);
    }

    public function test_customer_cannot_book_departure_in_same_day(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Sat Gio',
            'slug' => 'tour-sat-gio',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Da Lat',
            'slug' => 'tour-da-lat',
            'price' => 1700000,
            'sale_price' => 1500000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->toDateString(),
            'capacity' => 10,
            'booked_seats' => 0,
            'price' => 1500000,
            'status' => 'open',
        ]);

        $this->actingAs($user)
            ->from(route('products.detail', $product->slug))
            ->post(route('bookings.store', $product), [
                'departure_id' => $departure->id,
                'quantity' => 1,
            ])
            ->assertRedirect(route('products.detail', $product->slug))
            ->assertSessionHasErrors('departure_id');

        $this->assertDatabaseMissing('bookings', [
            'user_id' => $user->id,
            'departure_id' => $departure->id,
        ]);
    }

    public function test_customer_cannot_book_departure_within_24h_cutoff(): void
    {
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Cutoff',
            'slug' => 'tour-cutoff',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Vung Tau',
            'slug' => 'tour-vung-tau',
            'price' => 1200000,
            'sale_price' => 1000000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);

        $departureAt = now()->addHours(6);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => $departureAt->toDateString(),
            'departure_time' => $departureAt->format('H:i:s'),
            'capacity' => 12,
            'booked_seats' => 0,
            'price' => 1000000,
            'status' => 'open',
        ]);

        $this->actingAs($user)
            ->from(route('products.detail', $product->slug))
            ->post(route('bookings.store', $product), [
                'departure_id' => $departure->id,
                'quantity' => 1,
            ])
            ->assertRedirect(route('products.detail', $product->slug))
            ->assertSessionHasErrors('departure_id');

        $this->assertDatabaseMissing('bookings', [
            'user_id' => $user->id,
            'departure_id' => $departure->id,
        ]);
    }

    public function test_admin_cancelling_booking_restores_departure_seats(): void
    {
        $admin = User::factory()->create(['role' => 1]);
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Tay Bac',
            'slug' => 'tour-tay-bac',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Moc Chau',
            'slug' => 'tour-moc-chau',
            'price' => 1300000,
            'sale_price' => 1200000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(12)->toDateString(),
            'capacity' => 10,
            'booked_seats' => 3,
            'price' => 1200000,
            'status' => 'open',
        ]);
        $booking = Booking::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'departure_id' => $departure->id,
            'quantity' => 3,
            'unit_price' => 1200000,
            'total_price' => 3600000,
            'booking_date' => $departure->departure_date,
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->put(route('admin.bookings.update', $booking), [
                'status' => 'cancelled',
            ])
            ->assertRedirect(route('admin.bookings.index'));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
        ]);
        $this->assertDatabaseHas('departures', [
            'id' => $departure->id,
            'booked_seats' => 0,
        ]);
    }

    public function test_customer_cannot_upload_payment_proof_for_non_pending_booking(): void
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Bien 3',
            'slug' => 'tour-bien-3',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Phu Quoc',
            'slug' => 'tour-phu-quoc',
            'price' => 2500000,
            'sale_price' => 2300000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(15)->toDateString(),
            'capacity' => 12,
            'booked_seats' => 1,
            'price' => 2300000,
            'status' => 'open',
        ]);

        $booking = Booking::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'departure_id' => $departure->id,
            'quantity' => 1,
            'unit_price' => 2300000,
            'total_price' => 2300000,
            'booking_date' => $departure->departure_date,
            'status' => 'confirmed',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'paid',
            'transaction_code' => Booking::generateTransactionCode(1),
        ]);

        try {
            $this->actingAs($user)->post(route('bookings.proof', $booking), []);
            $this->fail('Expected HTTP 403 when uploading proof for non-pending booking.');
        } catch (HttpException $exception) {
            $this->assertSame(403, $exception->getStatusCode());
        }

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'payment_status' => 'paid',
        ]);
    }

    public function test_admin_confirming_cod_booking_keeps_payment_unpaid(): void
    {
        $admin = User::factory()->create(['role' => 1]);
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Dong Bac',
            'slug' => 'tour-dong-bac',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Ha Giang',
            'slug' => 'tour-ha-giang',
            'price' => 2600000,
            'sale_price' => 2400000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(20)->toDateString(),
            'capacity' => 10,
            'booked_seats' => 2,
            'price' => 2400000,
            'status' => 'open',
        ]);
        $booking = Booking::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'departure_id' => $departure->id,
            'quantity' => 2,
            'unit_price' => 2400000,
            'total_price' => 4800000,
            'booking_date' => $departure->departure_date,
            'status' => 'pending',
            'payment_method' => 'cod',
            'payment_status' => 'unpaid',
            'transaction_code' => Booking::generateTransactionCode(2),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.bookings.confirm', $booking))
            ->assertRedirect(route('admin.bookings.show', $booking));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'confirmed',
            'payment_status' => 'unpaid',
        ]);
        $this->assertFalse($booking->fresh()->isPayable());
    }

    public function test_admin_rejecting_waiting_verify_booking_sets_refund_pending(): void
    {
        $admin = User::factory()->create(['role' => 1]);
        $user = User::factory()->create();
        $category = Category::create([
            'name' => 'Tour Mien Trung',
            'slug' => 'tour-mien-trung',
            'description' => 'Danh muc',
        ]);
        $product = Product::create([
            'name' => 'Tour Quy Nhon',
            'slug' => 'tour-quy-nhon',
            'price' => 2100000,
            'sale_price' => 1900000,
            'category_id' => $category->id,
            'description' => 'Mo ta',
        ]);
        $departure = Departure::create([
            'product_id' => $product->id,
            'departure_date' => now()->addDays(14)->toDateString(),
            'capacity' => 8,
            'booked_seats' => 3,
            'price' => 1900000,
            'status' => 'open',
        ]);
        $booking = Booking::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'departure_id' => $departure->id,
            'quantity' => 3,
            'unit_price' => 1900000,
            'total_price' => 5700000,
            'booking_date' => $departure->departure_date,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'payment_status' => 'waiting_verify',
            'transaction_code' => Booking::generateTransactionCode(3),
        ]);

        $this->actingAs($admin)
            ->post(route('admin.bookings.reject', $booking), [
                'cancelled_reason' => 'Thong tin chuyen khoan khong hop le',
            ])
            ->assertRedirect(route('admin.bookings.show', $booking));

        $this->assertDatabaseHas('bookings', [
            'id' => $booking->id,
            'status' => 'cancelled',
            'payment_status' => 'refund_pending',
        ]);
    }
}
