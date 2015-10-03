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
      $this->recepient = $this->addCountryCode($recepient);
      return $this;
  }

  public function notify($subject, $message)
  {
      $params = array(
        'src' => $this->sender,
        'dst'  => $this->recepient,
        'text'=> $message
      );

      return $this->plivo->send_message($params);
  }

  private function addCountryCode($number)
  {
      $number_length = strlen($number);
      if($number_length === 10)
      {
        return "+91".$number;
      }

      return $number;
  }


}


?>
