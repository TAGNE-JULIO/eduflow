<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FeePaidNotification extends Notification
{
    use Queueable;

    public $amount;
    public $feeName;
    public $invoiceName;

    /**
     * Create a new notification instance.
     */
    public function __construct($amount, $feeName, $invoiceName)
    {
        $this->amount = $amount;
        $this->feeName = $feeName;
        $this->invoiceName = $invoiceName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'amount' => $this->amount,
            'fee_name' => $this->feeName,
            'invoice_name' => $this->invoiceName,
            'message' => "Payment of {$this->amount} received for {$this->feeName} ({$this->invoiceName})."
        ];
    }
}
