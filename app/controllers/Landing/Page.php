<?php
namespace Landing;
use BaseController;
use View;
use Config;


class Page extends BaseController {

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

}

?>
