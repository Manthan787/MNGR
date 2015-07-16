<?php
namespace Desk\Controller;
use View;
use Response;
use Redirect;
use Input;
class Study extends \BaseController
{
    public function getIndex()
    {
        return View::make('Desk.Dashboard.Study.index');
    }
} 