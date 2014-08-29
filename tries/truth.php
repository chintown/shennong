<?php
require './common/Shennong.php';

$shennong = new Shennong('truth');
$shennong->addTesters('fool', function($input)  {
    return 'yes';
});
$shennong->addTesters('wise', function($input)  {
    return $input === 'truth' ? 'yes' : 'wake up';
});
$shennong->addTestInputs(array(
    'truth',
    'lie'
));
$shennong->taste();
$shennong->jotDownResult();