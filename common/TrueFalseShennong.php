<?php
require 'Shennong.php';

class TrueFalseShennong extends Shennong {
    protected function markLabel($output) {
        if ($output === false) {
            return 'style="background-color:red"';
        } else {
            return 'style="background-color:green"';
        }
    }
}