<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::latest()->paginate(15);
        return view('admin.vouchers.index', compact('vouchers'));
    }

    public function create()
    {
        return view('admin.vouchers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'         => 'required|string|max:30|unique:vouchers,code',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:500',
            'type'         => 'required|in:fixed,percent',
            'value'        => 'required|integer|min:1',
            'max_discount' => 'nullable|integer|min:0',
            'min_order'    => 'nullable|integer|min:0',
            'max_uses'     => 'nullable|integer|min:1',
            'starts_at'    => 'nullable|date',
            'expires_at'   => 'nullable|date|after_or_equal:starts_at',
            'is_active'    => 'boolean',
        ], [
            'code.required' => 'Vui lòng nhập mã voucher.',
            'code.unique'   => 'Mã voucher đã tồn tại.',
            'name.required' => 'Vui lòng nhập tên voucher.',
            'type.required' => 'Vui lòng chọn loại giảm giá.',
            'value.required'=> 'Vui lòng nhập giá trị giảm.',
        ]);

        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active', true);
        $data['min_order'] = $data['min_order'] ?? 0;

        Voucher::create($data);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Tạo voucher "' . $data['code'] . '" thành công!');
    }

    public function edit(Voucher $voucher)
    {
        return view('admin.vouchers.edit', compact('voucher'));
    }

    public function update(Request $request, Voucher $voucher)
    {
        $data = $request->validate([
            'code'         => 'required|string|max:30|unique:vouchers,code,' . $voucher->id,
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:500',
            'type'         => 'required|in:fixed,percent',
            'value'        => 'required|integer|min:1',
            'max_discount' => 'nullable|integer|min:0',
            'min_order'    => 'nullable|integer|min:0',
            'max_uses'     => 'nullable|integer|min:1',
            'starts_at'    => 'nullable|date',
            'expires_at'   => 'nullable|date|after_or_equal:starts_at',
            'is_active'    => 'boolean',
        ]);

        $data['code'] = strtoupper(trim($data['code']));
        $data['is_active'] = $request->boolean('is_active', true);
        $data['min_order'] = $data['min_order'] ?? 0;

        $voucher->update($data);

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Cập nhật voucher thành công!');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Đã xóa voucher!');
    }
}
