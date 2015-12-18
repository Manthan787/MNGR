<?php
namespace Manthan\Webcompile\Program;
use SplFileObject;

class CppProgram extends Program {
  protected $compiler = 'g++';

  public function __construct($file, $args) {
      Parent::__construct($file, $args);
  }

  public function create() {
      $this->file = new SplFileObject('temp.cpp', 'w');
      $this->file->fwrite($this->content);
  }

  public function destroy() {
      if(file_exists($this->file->getFileName())) {
        unlink($this->file->getFileName());
      }
      if(file_exists('a.out')) {
        unlink('a.out');
      }
  }

  protected function getRunCommand() {
      return './a.out';
  }
}
?>
