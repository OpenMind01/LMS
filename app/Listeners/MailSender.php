<?php

namespace Pi\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use Pi\Events\Users\UserCreated;

class MailSender
{
    /**
     * @var Mailer
     */
    private $mailer;

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function onUserCreated(UserCreated $event)
    {
        \P4Mailer::send('registration-notification', $event->getUser()->email,
        [
            'user_email' => $event->getUser()->email,
            'user_password' => $event->getPassword()
        ]);
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            UserCreated::class,
            self::class . '@onUserCreated'
        );
    }
}