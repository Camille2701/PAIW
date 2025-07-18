<?php

namespace App\Models;

use App\Notifications\OrderStatusChanged;
use App\Support\GuestUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_price',
        'discount_amount',
        'status',
        'first_name',
        'last_name',
        'email',
        'street',
        'apartment',
        'city',
        'country',
        'postal_code',
        'shipping_method',
        'coupon_code',
        'coupon_discount',
        'tracking_number',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'shipping_price' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'coupon_discount' => 'decimal:4',
    ];

    protected static function booted()
    {
        static::updating(function ($order) {
            // Détecter les changements de statut
            if ($order->isDirty('status')) {
                $oldStatus = $order->getOriginal('status');
                $newStatus = $order->status;

                // Envoyer la notification seulement pour certains statuts
                $notifiableStatuses = ['shipped', 'delivered', 'cancelled'];

                if (in_array($newStatus, $notifiableStatuses)) {
                    // Envoyer la notification après la mise à jour
                    static::updated(function ($order) use ($oldStatus, $newStatus) {
                        if ($order->user) {
                            // Utilisateur connecté
                            $order->user->notify(new OrderStatusChanged($order, $oldStatus, $newStatus));
                        } else {
                            // Utilisateur invité - utiliser notre classe GuestUser
                            $guestUser = new GuestUser($order->email, $order->first_name, $order->last_name);
                            $guestUser->notify(new OrderStatusChanged($order, $oldStatus, $newStatus));
                        }
                    });
                }
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->orderItems->sum(function ($item) {
            return $item->quantity * $item->unit_price;
        });
    }
}
