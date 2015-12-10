<?php
namespace Manthan\Webcompile\Program;

class JavaProgram extends Program {
    protected $compiler   = 'javac';

    public function __construct($file, $args) {
        Parent::__construct($file, $args);
    }

    protected function getRunCommand() {
        $fileName = $this->extractFileName($this->file);
        return 'java '.$fileName;
    }

    public function destroy() {
        unlink($this->file);
        $classFile = $this->extractFileName($this->file).'.class';
        unlink($classFile);
    }

    protected function extractFileName($full) {
        return explode('.', $full)[0];
    }
}


?>
