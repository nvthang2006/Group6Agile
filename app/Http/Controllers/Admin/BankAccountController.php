<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BankAccountController extends AdminBaseController
{
    public function index()
    {
        $accounts = BankAccount::latest()->get();
        return view('admin.bank-accounts.index', compact('accounts'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:30',
            'account_name'   => 'required|string|max:100',
            'branch'         => 'nullable|string|max:200',
            'qr_code'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'boolean',
        ]);

        $data = $request->only(['bank_name', 'account_number', 'account_name', 'branch']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('qr_code')) {
            $data['qr_code'] = $request->file('qr_code')->store('bank_qr', 'public');
        }

        $account = BankAccount::create($data);

        // Nếu là tài khoản đầu tiên, tự động đặt làm chính
        if (BankAccount::count() === 1) {
            $account->makePrimary();
        }

        return back()->with('success', 'Đã thêm tài khoản ngân hàng thành công!');
    }

    public function update(Request $request, BankAccount $bankAccount)
    {
        $request->merge([
            'is_active' => $request->boolean('is_active'),
        ]);

        $request->validate([
            'bank_name'      => 'required|string|max:100',
            'account_number' => 'required|string|max:30',
            'account_name'   => 'required|string|max:100',
            'branch'         => 'nullable|string|max:200',
            'qr_code'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active'      => 'boolean',
        ]);

        $data = $request->only(['bank_name', 'account_number', 'account_name', 'branch']);
        $data['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('qr_code')) {
            if ($bankAccount->qr_code) {
                Storage::disk('public')->delete($bankAccount->qr_code);
            }
            $data['qr_code'] = $request->file('qr_code')->store('bank_qr', 'public');
        }

        $bankAccount->update($data);

        return back()->with('success', 'Đã cập nhật tài khoản ngân hàng!');
    }

    /**
     * Đặt tài khoản làm tài khoản chính hiển thị cho khách thanh toán.
     */
    public function setPrimary(BankAccount $bankAccount)
    {
        $bankAccount->makePrimary();

        return back()->with('success', 'Đã chọn "' . $bankAccount->bank_name . '" làm tài khoản thanh toán chính!');
    }

    public function destroy(BankAccount $bankAccount)
    {
        if ($bankAccount->qr_code) {
            Storage::disk('public')->delete($bankAccount->qr_code);
        }

        $bankAccount->delete();

        return back()->with('success', 'Đã xóa tài khoản ngân hàng!');
    }
}
