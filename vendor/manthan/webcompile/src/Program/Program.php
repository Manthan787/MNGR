<?php
namespace Manthan\Webcompile\Program;

abstract class Program implements ProgramInterface {

    protected $file;
    protected $output;
    protected $args;
    protected $compiler;
    protected $content;

    abstract protected function getRunCommand();
    abstract public function create();
    abstract public function destroy();

    public function __construct($content, $args = array(), $name = '') {
        $this->content  = $content;
        $this->args     = $args;
        $this->name     = $name;
    }

    public function execute() {
        if($this->compile()) {
            return $this->run();
        }
        else {
            return $this->output;
        }
    }

    protected function compile() {
        $command = $this->compiler." ".escapeshellarg($this->file->getFileName()).' 2>&1';
        exec($command, $output, $return_value);
        if($return_value !== 0) {
            $this->setOutput($output);
            return false;
        }
        return true;
    }


    protected function run() {
      $output = array();
      $desc =  array(
          0 => array('pipe', 'r'),
          1 => array('pipe', 'w'),
          2 => array('pipe', 'w')
      );
      flush();
      $process = proc_open($this->getRunCommand(), $desc, $pipes);

      if(!empty($this->args)) {
        foreach($this->args as $arg) {
          fwrite($pipes[0], $arg."\n");
        }
      }
      fclose($pipes[0]);
      if (is_resource($process)) {
          while ($s = fgets($pipes[1])) {
              $output[] = $s;
              flush();
          }
      }
      fclose($pipes[1]);
      $stderr = stream_get_contents($pipes[2]);
      fclose($pipes[2]);
      proc_close($process);

      if($this->hasError($stderr)) {
          $this->setOutput($stderr);
      }
      else {
          $this->setOutput($output);
      }
      return $this->output;
    }

    protected function hasError($output) {
        if(empty($output)) {
            return false;
        }
        return true;
    }

    protected function setOutput($op) {
      if(is_string($op)) {
        $this->output[] = $op;
      }
      else {
        $this->output = $op;
      }
    }

}


?>
