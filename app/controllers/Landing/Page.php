<?php
namespace Landing\Controller;
use BaseController;
use View;
use Config;
use mngr\Services\Mail\Notifier;
use Redirect;
use Input;
use Response;

class Page extends BaseController {

  protected $notifier;

  public function __construct (Notifier $notifier) {
      $this->notifier = $notifier;
  }

  public function index() {
      $Landing_Config = Config::get('Landing');
      return View::make('Landing.index')->with('Landing_Config', $Landing_Config);
  }

  public function about() {
      return View::make('Landing.about');
  }

  public function contact() {
      return View::make('Landing.contact');
  }

  public function postContact() {
      $data = array(
          'name'    => Input::get('name'),
          'email'   => Input::get('email'),
          'subject' => Input::get('subject'),
          'msg' => Input::get('message')
      );

      $sender   = Config::get('preferences.EMAIL');
      $receiver = Config::get('preferences.CONTACT_EMAIL');

      $this->notifier->from($sender)
                     ->subject("Somebody has contacted you!")
                     ->to($receiver)
                     ->notify('EmailNotification.contact',$data);

     return Response::json(['success' => true, 'message' => 'We have received your message, we will shortly get back to you! Thank you.'], 200);
  }
}

?>
