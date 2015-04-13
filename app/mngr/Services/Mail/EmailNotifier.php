<?php


namespace mngr\Services\Mail;
use Illuminate\Mail\Mailer;

class EmailNotifier implements Notifier{

    protected $mailer;
    protected $recipient;
    protected $sender;
    protected $subject;

    public function __construct(Mailer $laravelMailer)
    {
        $this->mailer = $laravelMailer;
    }

    public function to($to)
    {
        $this->recipient = $to;
        return $this;
    }

    public function from($from)
    {
        $this->sender = $from;
        return $this;
    }

    public function subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }
    public function notify($view, array $data)
    {
        $this->mailer->send($view, $data, function($message) {

            $message->from($this->sender, 'Administration');
            $message->to($this->recipient)->subject($this->subject);

        });
    }
} 