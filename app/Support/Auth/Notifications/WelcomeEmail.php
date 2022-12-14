<?php

namespace App\Support\Auth\Notifications;

use App\Support\Mail\Mailable;
use App\Support\Notifications\Contracts\Notifiable as NotifiableContract;
use App\Support\Notifications\Contracts\ViaMail;
use App\Support\Notifications\Notification;
use Closure;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class WelcomeEmail extends Notification implements ViaMail
{
    public static ?Closure $createUrlCallback = null;

    public static ?Closure $toMailCallback = null;

    protected function loginUrl(NotifiableContract $notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable);
        }

        return url(route('login', [], false));
    }

    public function dataMail(NotifiableContract $notifiable): Mailable|MailMessage|null
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }

        return $this->buildMailMessage($this->loginUrl($notifiable));
    }

    protected function buildMailMessage($url): MailMessage
    {
        return (new MailMessage)
            ->subject(Lang::get('New Registration'))
            ->line(Lang::get('You have completed your new registration.'))
            ->action(Lang::get('Login'), $url)
            ->line(Lang::get('If you did not create an account, no further action is required.'));
    }
}
