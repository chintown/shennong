<?php
require './common/TrueFalseShennong.php';

$test_cases = array(
    true,
    false,
    1,
    0,
    -1,
    "1",
    "0",
    "-1",
    "true",
    "false",
    Null,
    "foobar",
    "4779",
    "0x12AB",
    ""
);

$shennong = new TrueFalseShennong('equation');
foreach ($test_cases as $test_case) {
    $case_literal = var_export($test_case, true);
    $shennong->addTesters($case_literal, function($input) use($test_case) {
        return $input==$test_case;
    });
}
$shennong->addTestInputs($test_cases);
$shennong->taste();
$shennong->jotDownResult();