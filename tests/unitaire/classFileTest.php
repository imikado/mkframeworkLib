<?php

require_once(__DIR__.'/../../class_root.php');
require_once(__DIR__.'/../../class_file.php');

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classFileTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    public function test_isDirShouldFinishOk()
    {

				/*
        $oRoot = new _root();
        $oRoot->setConfigVar('site.mode', 'dev');
        $oRoot->setConfigVar('debug.class', 'fakeDebug');

        $oRoot->setConfigVar('log.class', 'fakeLog');

        $oRoot->setConfigVar('path.module', __DIR__.'/../data/module/');
        $oRoot->setConfigVar('path.view', 'view/');
				*/

        $oFile=new _file();

        $this->assertEquals(false, $oFile->isDir());
    }

		public function test_isFileShouldFinishOk()
    {
			$oFile=new _file();

			$this->assertEquals(true, $oFile->isFile());
		}

		public function test_setAdresseShouldFinishOk()
    {
			$oFile=new _file();
			$oFile->setAdresse('myPath');

			$this->assertEquals('myPath', $oFile->getAdresse());
		}

		public function test_setContentShouldFinishOk()
    {
			$oFile=new _file(__DIR__.'/../data/file_test.txt');
			$oFile->setContent('myContent');
			$oFile->save();

			$this->assertEquals('myContent', $oFile->getContent());
		}

		public function test_addContentShouldFinishOk()
    {
			file_put_contents(__DIR__.'/../data/file_test.txt','');

			$oFile=new _file(__DIR__.'/../data/file_test.txt');

			$oFile->addContent('a');
			$oFile->addContent('b');
			$oFile->save();

			$this->assertEquals('ab', $oFile->getContent());
		}

		public function test_cleanShouldFinishOk()
    {
			$oFile=new _file(__DIR__.'/../data/file_test.txt');

			$oFile->clean();

			$this->assertEquals('', $oFile->getAdresse());
		}

		public function test_getNameShouldFinishOk()
    {

			$oFile=new _file(__DIR__.'/../data/file_test.txt');

			$this->assertEquals('file_test.txt', $oFile->getName());
		}
}
