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
        $program = Input::get('program');
        $args    = explode(',', Input::get('inputs'));
        $result = $this->compiler->type('c')->with($program, $args)->executeProgram();
        return $result;
    }

}


?>
