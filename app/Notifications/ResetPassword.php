<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends Notification implements ShouldQueue
{
    use Queueable;

    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
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

        return (new MailMessage)
                    ->subject('Сброс пароля')
                    ->line('Вы запросили сброс пароля для своего аккаунта для веб-платформы "Ярмарка проектов"')
                    ->action('Сбросить пароль', url(route('resetForm', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                    ->line(Lang::get('Эта ссылка истечет через :count минут', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                    ->line('Проигнорируйте это письмо, если вы не запрашивали сброс пароля');
    }

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
