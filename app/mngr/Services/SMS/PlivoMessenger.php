<?php
namespace mngr\Services\SMS;
use Manthan\Nuncio\MessengerInterface;
use Plivo\RestAPI as Plivo;

class PlivoMessenger implements MessengerInterface
{

  protected $sender;
  protected $recepient;
  protected $plivo;

  public function __construct(Plivo $plivo)
  {
      $this->plivo = $plivo;
  }

  public function from($sender)
  {
      $this->sender = $sender;
      return $this;
  }

  public function to($recepient)
  {
      $this->recepient = $recepient;
      return $this;
  }

  public function notify($subject, $message)
  {
      $params = array(
        'src' => $this->sender,
        'dst'  => $this->recepient,
        'text'=> $message
      );

      $this->plivo->send_message($params);
  }


}


?>
