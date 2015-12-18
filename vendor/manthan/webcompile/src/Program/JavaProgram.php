<?php
namespace Manthan\Webcompile\Program;

use SplFileObject;

class JavaProgram extends Program {
    protected $compiler   = 'javac';

    public function create() {
        $this->file = new SplFileObject($this->name, "w");
        $this->file->fwrite($this->content);
    }

    protected function getRunCommand() {
        $fileName = $this->extractFileName($this->name);
        return "java {$fileName} 2>&1";
    }

    public function destroy() {
        if(file_exists($this->name)) {
         unlink($this->name);
        }
        $classFile = $this->extractFileName($this->name).'.class';
        if(file_exists($classFile)) {
         unlink($classFile);
       }
    }

    protected function extractFileName($full) {
        return explode('.', $full)[0];
    }
}
?>
