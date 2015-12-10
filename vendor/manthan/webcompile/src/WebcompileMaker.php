<?php
namespace Manthan\Webcompile;

use Manthan\Webcompile\Program\ProgramFactory;

class WebcompileMaker {

    protected $language;
    protected $program;

    public function type($language) {
      $this->language = $language;
      return $this;
    }

    public function with($content, $args = array(), $name = '') {
        $this->program = ProgramFactory::create($this->language, $content, $args, $name);
        $this->program->create();
        return $this;
    }

    public function executeProgram() {
        $response = $this->program->execute();
        $this->program->destroy();
        return $response;
    }


}


?>
