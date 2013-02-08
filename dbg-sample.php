<?php
function test_func(&$arg1) {
  var_dump($arg1);
  return "hello";
}

  $tst = array(0=>"element1", "a"=>"element2");
  $a = test_func($tst);
  echo "$a world"
?>