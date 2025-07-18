<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification
{
    use Queueable;

    public $order;
    public $oldStatus;
    public $newStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus, string $newStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
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
        $statusMessages = [
            'pending' => [
                'title' => '⏳ Commande en attente',
                'message' => 'Votre commande est en cours de traitement.',
                'color' => '#ffc107'
            ],
            'paid' => [
                'title' => '✅ Paiement confirmé',
                'message' => 'Votre paiement a été confirmé avec succès.',
                'color' => '#28a745'
            ],
            'processing' => [
                'title' => '📦 Commande en préparation',
                'message' => 'Votre commande est en cours de préparation dans nos entrepôts.',
                'color' => '#17a2b8'
            ],
            'shipped' => [
                'title' => '🚚 Commande expédiée',
                'message' => 'Votre commande a été expédiée et est en route vers vous !',
                'color' => '#007bff'
            ],
            'delivered' => [
                'title' => '🎉 Commande livrée',
                'message' => 'Votre commande a été livrée avec succès.',
                'color' => '#28a745'
            ],
            'cancelled' => [
                'title' => '❌ Commande annulée',
                'message' => 'Votre commande a été annulée.',
                'color' => '#dc3545'
            ]
        ];

        $statusInfo = $statusMessages[$this->newStatus] ?? [
            'title' => '📋 Mise à jour de commande',
            'message' => 'Le statut de votre commande a été mis à jour.',
            'color' => '#6c757d'
        ];

        return (new MailMessage)
            ->view('emails.order-status-changed', [
                'order' => $this->order,
                'user' => $notifiable,
                'oldStatus' => $this->oldStatus,
                'newStatus' => $this->newStatus,
                'statusInfo' => $statusInfo,
            ])
            ->subject($statusInfo['title'] . ' - Commande #' . $this->order->id);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
        ];
    }
}
