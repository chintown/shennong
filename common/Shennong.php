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
     * add an user-defined executor which will
     * exam the test cases one by one
     * @param string   $name     display name shown on jotDownResult html table
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

    public function taste() {
        foreach ($this->testInputs as $input) {
            $outputs = array();
            foreach ($this->testers as $name => $executor) {
                try {
                    $outputs[$name] = $executor($input);
                } catch (Exception $e) {
                    $outputs[$name] = '['.$e->getMessage().']';
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
     * what "label" should be attached to jotDownResult html
     * so that visual styles can be easily applied on them
     * @param  mixed $output executed result
     * @return string         any html string which will be attached to dom element
     */
    protected function markLabel($output) {
        return ''; // by default, do nothing
    }
    /**
     * render result into html table stored in {$this->name}.html
     */
    public function jotDownResult() {
        ob_start();
?>
    <table border="1">
        <tr>
            <th>[<?=$this->name?>]<br>test</th>
            <?php foreach($this->testers as $name=>$executor) {
                echo "<th>$name</th>\n";
            } ?>
        </tr>
        <?php
            foreach($this->result as $row) {
                $test_input_literal = var_export($row['test_input'], true);
                echo "<tr>\n";
                echo "<td>$test_input_literal</td>\n";
                foreach($row['test_outputs'] as $column_result) {
                    $result_literal = var_export($column_result, true);
                    $label = $this->markLabel($column_result);
                    echo "<td $label>$result_literal</td>\n";
                }
                echo "</tr>\n";
            }
        ?>
    </table>
<?php
        $output = ob_get_contents();
        ob_end_clean();
        file_put_contents('./output/'.$this->name.'.html', $output);
    }
}