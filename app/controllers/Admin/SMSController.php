<?php
namespace Admin;
use BaseController;
use Input;
use Config;
use Exception;
use Response;
use mngr\Services\SMS\SMSNotifier;
use Manthan\Nuncio\MessengerInterface;

class SMSController extends BaseController
{
    protected $notifier;

    protected $messenger;

    public function __construct(SMSNotifier $notifier, MessengerInterface $messenger)
    {
        $this->notifier  = $notifier;  // For Messages processed by Manthan\Nuncio
        $this->messenger = $messenger; // For Quick Messages
    }

    public function send()
    {

      $recepients = json_decode(json_encode(Input::get('recepients')),FALSE);
      $message    = Input::get('message');

      $plivo_src = Config::get('plivo.src');

      try {
        $this->notifier->from($plivo_src)->to($recepients)->send('Regarding Attendance', $message);
        return Response::json(['msg' => 'SMS Notifications sent successfully.'], 200);
      }
      catch(Exception $e) {
        return Response::json(['msg' => 'There was an error while sending message(s). Please try again later.'], 500);
      }

    }

    public function quick()
    {
      $recepient = Input::get('number');
      $message   = Input::get('message');
      $plivo_src = Config::get('plivo.src');
      try {
        $this->messenger->from($plivo_src)->to($recepient)->notify('', $message);
        return Response::json(['msg'=> 'SMS notification sent successfully'], 200);
      }
      catch(Exception $e) {
        return Response::json(['msg' => 'There was an error while sending this message. Please try again later.'], 500);
      }
    }
}

?>
