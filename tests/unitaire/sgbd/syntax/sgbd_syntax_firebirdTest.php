<?php
require_once(__DIR__.'/../../../../sgbd/syntax/sgbd_syntax_firebird.php');




/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_syntax_firebirdTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_getListColumnShouldFinishOk()
    {
        $sTable='myTable';
        $sExpectedReturn='select  f.rdb$field_name from rdb$relation_fields f
		join rdb$relations r on f.rdb$relation_name = r.rdb$relation_name
		and r.rdb$view_blr is null
		and (r.rdb$system_flag is null or r.rdb$system_flag = 0)

		WHERE f.rdb$relation_name=\''.$sTable.'\' ';

        $oSgbdSyntax=new sgbd_syntax_firebird();

        $this->assertEquals($sExpectedReturn, $oSgbdSyntax->getListColumn($sTable));
    }
}
