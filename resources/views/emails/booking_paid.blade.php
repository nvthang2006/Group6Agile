<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác nhận thanh toán Hóa đơn - Tour Manager</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; color: #333;">

    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        
        <!-- Header -->
        <div style="background-color: #4361ee; padding: 30px; text-align: center; color: #ffffff;">
            <h1 style="margin: 0; font-size: 24px;">Tour Manager</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px; opacity: 0.9;">Xác nhận thanh toán thành công</p>
        </div>

        <!-- Body -->
        <div style="padding: 30px;">
            <p style="font-size: 16px; line-height: 1.5;">Xin chào <strong>{{ $booking->user->name ?? 'Quý khách' }}</strong>,</p>
            <p style="font-size: 16px; line-height: 1.5;">Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của <strong>Tour Manager</strong>. Chúng tôi xác nhận đã nhận được khoản thanh toán cho đơn hàng của bạn.</p>

            <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin: 25px 0;">
                <h3 style="margin-top: 0; color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px;">Chi tiết Đơn hàng (#{{ $booking->transaction_code }})</h3>
                
                <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
                    <tr>
                        <td style="padding: 8px 0; color: #64748b; width: 40%;">Tên Tour / Dịch vụ:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a;">{{ $booking->product->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Khách hàng:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a;">{{ $booking->user->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Ngày khởi hành:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a;">{{ $booking->departure ? \Carbon\Carbon::parse($booking->departure->departure_date)->format('d/m/Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Số người:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #0f172a;">{{ $booking->quantity }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #64748b;">Số tiền đã thanh toán:</td>
                        <td style="padding: 8px 0; font-weight: bold; color: #2563eb; font-size: 16px;">{{ number_format($booking->total_price, 0, ',', '.') }}đ</td>
                    </tr>
                </table>
            </div>

            <p style="font-size: 16px; line-height: 1.5;">Chi tiết về Hóa đơn / Vé điện tử (Đã bao gồm mã Booking) đã được chúng tôi đính kèm dưới dạng file <strong>PDF</strong> trong email này. Vui lòng tải xuống và xuất trình cho Hướng dẫn viên trong ngày khởi hành.</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ route('home') }}" style="display: inline-block; background-color: #4361ee; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 5px; font-weight: bold; font-size: 16px;">Trang chủ Tour Manager</a>
            </div>

            <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 30px 0;">

            <h4 style="margin: 0 0 10px 0; color: #1e293b;">Thông tin thêm & Lưu ý:</h4>
            <ul style="color: #64748b; font-size: 14px; line-height: 1.6; padding-left: 20px;">
                <li>Vui lòng có mặt tại điểm đón trước 30 phút so với giờ khởi hành.</li>
                <li>Hóa đơn này chỉ có giá trị khi toàn bộ dịch vụ đã được thanh toán đầy đủ.</li>
                <li>Mọi thắc mắc hoặc yêu cầu hoàn/hủy tour, vui lòng liên hệ trực tiếp với chúng tôi qua Hotline hoặc Zalo hỗ trợ.</li>
            </ul>

        </div>

        <!-- Footer -->
        <div style="background-color: #f1f5f9; padding: 20px; text-align: center; color: #64748b; font-size: 13px;">
            <p style="margin: 0;">© {{ date('Y') }} Tour Manager. All rights reserved.</p>
            <p style="margin: 5px 0 0 0;">Email này được gửi tự động từ hệ thống. Vui lòng không trả lời.</p>
        </div>

    </div>

</body>
</html>
