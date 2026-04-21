<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingPaidMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;

    /**
     * Create a new message instance.
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hóa đơn Thanh toán Xác nhận - Tour Manager',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking_paid',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $pdf = Pdf::loadView('client.pdf.voucher', ['booking' => $this->booking])
                  ->setPaper('a4', 'portrait');

        return [
            Attachment::fromData(fn () => $pdf->output(), 'Hoa_Don_' . $this->booking->transaction_code . '.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
