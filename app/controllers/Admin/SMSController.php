<?php
namespace Admin;
use BaseController;
use Input;
use Config;
use Exception;
use Response;
use mngr\Services\SMS\SMSNotifier;

class SMSController extends BaseController
{
    public function __construct(SMSNotifier $notifier)
    {
        $this->notifier = $notifier;
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

        return Response::json(['msg' => $e->getMessage()], 500);
      }

    }
}

?>
