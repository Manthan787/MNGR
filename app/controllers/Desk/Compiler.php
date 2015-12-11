<?php
namespace Desk\Controller;
use BaseController;
use Input;
use View;
use Manthan\Webcompile\WebcompileMaker;

class Compiler extends BaseController {

    public function __construct(WebcompileMaker $compiler) {
        $this->compiler = $compiler;
    }

    public function getCompiler() {
        return View::make('Desk.Compiler.compiler');
    }

    public function compile() {
      if(empty(Input::get('program'))) {
        return ['You must write a program first in order to execute!'];
      }
        $language = Input::get('language');
        $program  = Input::get('program');
        $name     = Input::get('name');
        $args     = explode(',', Input::get('inputs'));
        $result   = $this->compiler->type($language)->with($program, $args, $name)->executeProgram();
        return $result;
    }

}


?>
