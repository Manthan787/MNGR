<?php
namespace Desk\Controller;
use BaseController;
use View;
class Dashboard extends BaseController {
    public function getIndex()
    {
        return View::make('Desk.Dashboard.index');
    }

    public function getProfile()
    {
        return View::make('Desk.Dashboard.profile');
    }
} 