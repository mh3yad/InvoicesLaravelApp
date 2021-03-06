<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceCreate extends Notification implements ShouldQueue
{
    use Queueable;

    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @param $invoice
     */
    public function __construct($invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/invoices/'.$this->invoice->id);

        return (new MailMessage)
            ->subject('Invoice created')
            ->from('mhayad010@gmail.com', 'sayed')
            ->greeting('Hello!')
            ->line('One of your invoices has been added!')
            ->action('View Invoice', $url)
            ->line('Thank you for using our application!');
    }
//    public function routeNotificationForMail($notification)
//    {
//        // Return email address only...
//        return 'mh3yad@gmail.com';
//
//        // Return name and email address...
//
//    }
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
