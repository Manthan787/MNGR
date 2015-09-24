<?php
namespace Landing;
use BaseController;
use View;
use Config;


class Page extends BaseController {

  public function index() {
      $preferences = Config::get('preferences');
      return View::make('Landing.index')->with('preferences', $preferences);
  }


}


?>
