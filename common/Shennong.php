<?php

/**
 *                 tester 1    tester 2   ...
 * test input 1    result 1-1  result 1-2   ...
 * test input 2    ...
 */
class Shennong {
    private $name;
    private $testInputs;
    private $testers;
    private $result;
    public function __construct($name) {
        $this->name = $name;
        $this->testInputs = array();
        $this->testers = array();
        $this->result = array();
    }
    /**
     * add an user-defined tester which will
     * exam the test input one by one
     * @param string   $name   display name shown on output html table
     * @param callable $tester testing unit
     */
    public function addTesters($name, callable $tester) {
        $this->testers[$name] = $tester;
    }

    /**
     * add a testing input which will be feed into each tester
     * @param mixed $input
     */
    public function addTestInput($input) {
        $this->testInputs[] = $input;
    }
    /**
     * add an array of testing input which will be feed into each tester
     * @param Array $inputs
     */

    public function addTestInputs($inputs) {
        $this->testInputs = array_merge($this->testInputs, $inputs);
    }
    /**
     * do test
     */
    public function taste() {
        foreach ($this->testInputs as $input) {
            $outputs = array();
            foreach ($this->testers as $name => $executor) {
                try {
                    $outputs[] = $executor($input);
                } catch (Exception $e) {
                    $outputs[] = '['.$e->getMessage().']';
                }
            }
            $this->result[] = array(
                'test_input' => $input,
                'test_outputs'=> $outputs
            );
        }
    }
    /**
     * given a result value, client can decide
     * what "label" should be attached to output html
     * so that visual styles can be easily applied on them
     * @param  mixed $output testing result
     * @return string        any html string which will be attached to dom element
     */
    protected function markLabel($output) {
        return ''; // by default, do nothing
    }
    /**
     * render result into html table stored in {$this->name}.html
     */
    public function jotDownResult() {
        $head_row = array_merge(array("[{$this->name}]<br>test"), array_keys($this->testers));
        $body_rows = array_map(function($row) {
            return array_merge(array($row['test_input']), $row['test_outputs']);
        }, $this->result);


        ob_start();
?>
    <style>td:nth-child(1) {font-family: monospace;}</style>
    <table border="1">
        <?
            echo "<tr>";
            $lines = array_map(function($head) {
                return "<th>$head</th>";
            }, $head_row);
            echo implode("\n", $lines);
            echo "</tr>";
        ?>

        <?
            $lines = array_map(function($row) {
                $line_parts = array_map(function($column, $idx) {
                    $literal = var_export($column, true);
                    $label = $idx === 0 ? '' : $this->markLabel($column);
                    return "<td $label>{$literal}</td>";
                }, $row, array_keys($row));
                return '<tr>'.implode("\n", $line_parts).'</tr>';
            }, $body_rows);
            echo implode("\n", $lines);
        ?>
    </table>
    <p>PHP version: <?=phpversion();?></p>
<?php
        $output = ob_get_contents();
        ob_end_clean();


        file_put_contents('./output/'.$this->name.'.html', $output);
    }
}