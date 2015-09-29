<?php
namespace mngr\Services\SMS;
use Manthan\Nuncio\Nuncio;
use Manthan\Nuncio\MessageProcessor;
use Manthan\Nuncio\MessengerInterface;


class SMSNotifier extends Nuncio
{
    protected $keywords     = array('name', 'email');
    protected $number_field = 'parents_mobile';


    public function __construct(MessengerInterface $messenger, MessageProcessor $processor)
    {
      parent::__construct($messenger, $processor);
    }



}

?>
