<?php
require 'vendor/autoload.php';
use Manthan\Webcompile\WebcompileMaker;

if(isset($_POST['program'])) {
  $compiler = new WebcompileMaker();
  $args = explode(',', $_POST['inputs']);
  $result = $compiler->type('c')->with($_POST['program'], $args)->executeProgram();
  print_r($result);
}
?>

<html>
<head>
  <title>Execute a C Program</title>
  <style>
  textarea.styled {
    width: 600;
    height: 600px;
    border: 3px solid #cccccc;
    padding: 5px;
    font-family: Tahoma, sans-serif;
    font-size: 19;
    outline: none;
    color: #DF635B;
    background: #464646;
    background-position: bottom right;
    background-repeat: no-repeat;
  }
  </style>
  <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script src="jquery-linedtextarea/jquery-linedtextarea.js"></script>
</head>
<body>
  <form method="POST">
    <textarea name="program" class="styled" id="code" spellcheck="false"></textarea>
    <br>
    <h4>Inputs</h4>
    <textarea name="inputs"></textarea>
    <br>
    <input type="submit" value="Execute">
  </form>
  <br>



</body>
</html>
