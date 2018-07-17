<?php

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_file.php');

require_once(__DIR__.'/../../tests/inc/fakeDebug.php');
require_once(__DIR__.'/../../tests/inc/fakeLog.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classLayoutTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_setShouldFinishOk()
    {
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');

        $oFile=new _file(__DIR__.'/../data');

        $this->assertEquals('val1', $oFile->isDir());
    }
}
