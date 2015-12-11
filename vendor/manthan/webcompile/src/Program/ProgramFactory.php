<?php
namespace Manthan\Webcompile\Program;

class ProgramFactory {

    public static function create($language, $content, $inputs = array(), $name = '') {
          $programClass = "Manthan\Webcompile\Program\\".ucfirst($language).'Program';
          if(class_exists($programClass)) {
              $Program = new $programClass($content, $inputs, $name);
              return $Program;
          }
          else {
              throw new \Exception("Invalid Programming Language Chosen. We do not support ".$language." programming language");
          }
    }
}
?>
