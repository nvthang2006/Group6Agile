<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Hóa đơn Đặt Tour - {{ $booking->transaction_code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 30px;
            color: #334155;
            font-size: 14px;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            vertical-align: top;
        }
        
        /* Header */
        .header-table {
            margin-bottom: 40px;
        }
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #4361ee;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 12px;
            color: #64748b;
            line-height: 1.6;
        }
        .invoice-title {
            font-size: 26px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
            text-transform: uppercase;
        }
        .invoice-details {
            font-size: 13px;
        }
        .invoice-details strong {
            display: inline-block;
            width: 70px;
            color: #475569;
        }

        /* Billing Info */
        .billing-table {
            margin-bottom: 30px;
        }
        .billing-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px;
            border-radius: 6px;
        }
        .billing-title {
            font-size: 12px;
            text-transform: uppercase;
            font-weight: bold;
            color: #94a3b8;
            margin-bottom: 8px;
        }
        .billing-name {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 4px;
        }

        /* Items Table */
        .items-table {
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #4361ee;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
            padding: 12px 10px;
            text-align: left;
        }
        .items-table td {
            padding: 15px 10px;
            border-bottom: 1px solid #e2e8f0;
            color: #1e293b;
        }
        .item-name {
            font-weight: bold;
            font-size: 15px;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .item-note {
            font-size: 12px;
            color: #64748b;
        }

        /* Totals */
        .totals-table {
            width: 100%;
        }
        .totals-table td {
            padding: 8px 10px;
            border-bottom: 1px solid #f1f5f9;
        }
        .totals-table .total-row td {
            border-bottom: none;
            padding-top: 15px;
            font-size: 18px;
            font-weight: bold;
            color: #4361ee;
        }

        /* Footer */
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #64748b;
        }
        .qr-box {
            margin-top: 30px;
            text-align: center;
        }
        .status-badge {
            display: inline-block;
            background-color: #dcfce7;
            color: #16a34a;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            border: 1px solid #bbf7d0;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="50%">
                <div class="company-name">TourManager</div>
                <div class="company-details">
                    Tầng 6, Tòa nhà Agile, Đống Đa, Hà Nội<br>
                    Website: www.tourmanager.com<br>
                    Email: support@tourmanager.com<br>
                    Hotline: 1900 1234
                </div>
            </td>
            <td width="50%" align="right">
                <div class="invoice-title">HÓA ĐƠN</div>
                <div class="invoice-details">
                    <table width="100%">
                        <tr>
                            <td align="right"><strong>Số HĐ:</strong></td>
                            <td align="right" width="100">{{ $booking->voucher_code ?? 'VOU-PENDING' }}</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Mã GD:</strong></td>
                            <td align="right">#{{ $booking->transaction_code }}</td>
                        </tr>
                        <tr>
                            <td align="right"><strong>Ngày:</strong></td>
                            <td align="right">{{ \Carbon\Carbon::parse($booking->paid_at ?? $booking->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table>

    <!-- Billing Info -->
    <table class="billing-table">
        <tr>
            <td width="48%">
                <div class="billing-box">
                    <div class="billing-title">THÔNG TIN KHÁCH HÀNG (BILLED TO)</div>
                    <div class="billing-name">{{ $booking->customer_name ?? $booking->user->name }}</div>
                    <div>Email: {{ $booking->customer_email ?? $booking->user->email }}</div>
                    <div>Điện thoại: {{ $booking->customer_phone ?? ($booking->user->phone ?? 'Không có') }}</div>
                </div>
            </td>
            <td width="4%"></td>
            <td width="48%">
                <div class="billing-box">
                    <div class="billing-title">TRẠNG THÁI THANH TOÁN (STATUS)</div>
                    <div style="margin-top: 10px;">
                        <span class="status-badge">ĐÃ THANH TOÁN KHOẢN KẾT TOÁN</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- Items -->
    <table class="items-table">
        <thead>
            <tr>
                <th width="45%">Mô tả Dịch vụ</th>
                <th width="15%" align="center">Ngày đi</th>
                <th width="10%" align="center">SL</th>
                <th width="15%" align="right">Đơn giá</th>
                <th width="15%" align="right">Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="item-name">{{ $booking->product->name }}</div>
                    @if($booking->note)
                        <div class="item-note">Ghi chú: {{ $booking->note }}</div>
                    @endif
                </td>
                <td align="center">{{ \Carbon\Carbon::parse($booking->departure->departure_date)->format('d/m/Y') }}</td>
                <td align="center">{{ $booking->quantity }}</td>
                <td align="right">{{ number_format($booking->unit_price, 0, ',', '.') }}đ</td>
                <td align="right">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <table width="100%">
        <tr>
            <td width="55%">
                <div class="qr-box">
                    <div style="font-size: 11px; color: #94a3b8; margin-bottom: 5px;">MÃ VÉ KHỞI HÀNH (VOUCHER)</div>
                    <div style="display: inline-block; border: 2px dashed #cbd5e1; padding: 10px 20px; font-weight: bold; font-size: 18px; color: #0f172a; letter-spacing: 2px;">
                        {{ $booking->voucher_code ?? 'VOU-PENDING' }}
                    </div>
                </div>
            </td>
            <td width="45%">
                <table class="totals-table">
                    <tr>
                        <td>Thành tiền:</td>
                        <td align="right">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
                    </tr>
                    <tr>
                        <td>Thuế VAT (0%):</td>
                        <td align="right">0đ</td>
                    </tr>
                    <tr class="total-row">
                        <td>TỔNG CỘNG:</td>
                        <td align="right">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Cảm ơn quý khách đã tin tưởng và sử dụng dịch vụ của TourManager.<br>
        Hóa đơn này được tạo tự động bởi hệ thống và có giá trị sử dụng khi quý khách tham gia tour.
    </div>

</body>
</html>
