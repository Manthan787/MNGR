<?php
namespace mngr\Services\Mail;

interface Notifier
{
    public function to($recepient);

    public function from($sender);

    public function subject($subject);

    public function notify($view, array $data);
}