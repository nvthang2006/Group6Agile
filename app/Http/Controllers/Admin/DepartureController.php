<?php

namespace App\Http\Controllers\Admin;

use App\Models\Departure;
use App\Models\Product;
use Illuminate\Http\Request;

class DepartureController extends AdminBaseController
{
    public function index(Product $product)
    {
        $departures = $product->departures()
            ->orderBy('departure_date')
            ->orderBy('departure_time')
            ->get();

        return view('admin.products.departures.index', compact('product', 'departures'));
    }

    public function store(Request $request, Product $product)
    {
        $data = $this->validateData($request);
        $data['product_id'] = $product->id;

        Departure::create($data);

        return back()->with('success', 'Tạo lịch khởi hành thành công.');
    }

    public function update(Request $request, Product $product, Departure $departure)
    {
        $this->ensureBelongsToProduct($product, $departure);
        $data = $this->validateData($request);

        if ((int) $data['capacity'] < (int) $departure->booked_seats) {
            return back()->withErrors([
                'capacity' => 'Sức chứa không được nhỏ hơn số chỗ đã đặt.',
            ]);
        }

        $departure->update($data);

        return back()->with('success', 'Cập nhật lịch khởi hành thành công.');
    }

    public function destroy(Product $product, Departure $departure)
    {
        $this->ensureBelongsToProduct($product, $departure);

        if ($departure->booked_seats > 0) {
            return back()->withErrors([
                'departure' => 'Không thể xóa lịch đang có chỗ đã đặt.',
            ]);
        }

        $departure->delete();

        return back()->with('success', 'Đã xóa lịch khởi hành.');
    }

    protected function validateData(Request $request): array
    {
        return $request->validate([
            'departure_date' => ['required', 'date', 'after_or_equal:today'],
            'departure_time' => ['required', 'date_format:H:i'],
            'capacity' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0'],
            'status' => ['required', 'in:open,closed,cancelled'],
        ]);
    }

    protected function ensureBelongsToProduct(Product $product, Departure $departure): void
    {
        abort_if($departure->product_id !== $product->id, 404);
    }
}
