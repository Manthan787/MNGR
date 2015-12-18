<?php
namespace Manthan\Webcompile\Program;
use SplFileObject;

class CProgram extends Program {
    protected $compiler = 'gcc';

    public function create() {
        $this->file = new SplFileObject('temp.c', 'w');
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
        return './a.out 2>&1';
    }
}
?>
