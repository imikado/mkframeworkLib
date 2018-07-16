<?php 

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_view.php');


class fakeDebug2{
	
	public function show($sText){
		throw new Exception($sText);
	}
}

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classViewTest extends PHPUnit_Framework_TestCase {

	public function run(PHPUnit_Framework_TestResult $result = NULL) {
		$this->setPreserveGlobalState(false);
		return parent::run($result);
	}

	public function test_ShoulFinishOk() {
		$this->assertEquals(true,true);
	}
	
	public function test_setShouldFinishOk(){
	
	$oRoot = new _root();
		$oRoot->setConfigVar('site.mode','dev');
		$oRoot->setConfigVar('debug.class','fakeDebug2');
		
		$oView=new _view('default::index');
		$oView->var1='val1';
		
		$this->assertEquals('val1',$oView->var1);
	}
	
}
