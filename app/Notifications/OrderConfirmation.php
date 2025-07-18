<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderConfirmation extends Notification
{
    use Queueable;

    public $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        // Générer le PDF de la facture
        $pdf = Pdf::loadView('emails.invoice-pdf', [
            'order' => $this->order,
            'user' => $notifiable
        ]);

        return (new MailMessage)
            ->view('emails.order-confirmation', [
                'order' => $this->order,
                'user' => $notifiable,
            ])
            ->subject('Confirmation de votre commande #' . $this->order->id . ' - ' . config('app.name'))
            ->attachData($pdf->output(), 'facture-' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
