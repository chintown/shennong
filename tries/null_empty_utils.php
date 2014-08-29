<?php
require './common/TrueFalseShennong.php';

$testing_var;

$shennong = new TrueFalseShennong('null_empty_util');
$shennong->addTesters('isset', function($input) {return isset($input);});
$shennong->addTesters('empty', function($input) {return empty($input);});
$shennong->addTesters('is_null', function($input) {return is_null($input);});
$shennong->addTestInputs(array(
    "",
    " ",
    False,
    True,
    array(),
    Null,
    "0",
    0,
    0.0,
    $var,
    "\0"
));
$shennong->taste();
$shennong->jotDownResult();