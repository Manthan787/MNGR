<?php
namespace Landing;
use BaseController;
use View;
use Config;


class Page extends BaseController {

  public function index() {

      return View::make('Landing.index');
  }

  public function contact() {
      return View::make('Landing.contact');
  }
}


?>
