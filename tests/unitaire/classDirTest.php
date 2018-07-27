<?php
require_once(__DIR__.'/../../class_file.php');
require_once(__DIR__.'/../../class_dir.php');


/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class classDirTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

    private function getDirname()
    {
        return __DIR__.'/../data/dirTest';
    }

    public function test_isDirShouldFinishOk()
    {
        $oDir=new _dir('myPath');

        $this->assertTrue($oDir->isDir());
    }

    public function test_isFileShouldFinishOk()
    {
        $oDir=new _dir('myPath');

        $this->assertFalse($oDir->isFile());
    }

    public function test_setAdresseShouldFinishOk()
    {
        $oDir=new _dir();
        $oDir->setAdresse('myPath');

        $this->assertEquals('myPath', $oDir->getAdresse());
    }

    public function test_getNameShouldFinishOk()
    {
        $oDir=new _dir($this->getDirname());

        $this->assertEquals('dirTest', $oDir->getName());
    }

    public function test_existShouldFinishOk()
    {
        $oDir=new _dir($this->getDirname());

        $this->assertTrue($oDir->exist());
    }

    public function test_getListShouldFinishOk()
    {
        $tExpectedList=array(
            array(false,'subDirTest1'),
            array(false,'subDirTest2'),
            array(true,'file1.txt'),
            array(true,'file2.txt'),
        );

        $oDir=new _dir($this->getDirname());
        $tList=$oDir->getList();

        $bOk=true;

        $tError=array();

        foreach ($tExpectedList as $tCheck) {
            if (false==$this->findItemInArray($tCheck, $tList)) {
                $tError[]= $tCheck[1]." not found";
                $bOk=false;
            }
        }

        $this->assertTrue($bOk, 'errors: '.implode("\n", $tError));
    }

    private function findItemInArray($tCheck_, $tList_)
    {
        list($isFile, $sName)=$tCheck_;
        foreach ($tList_ as $oItem) {
            if ($oItem->isFile() == $isFile and $oItem->getName()==$sName) {
                return true;
            }
        }
        return false;
    }

    public function test_getListFileShouldFinishOk()
    {
        $tExpectedList=array(

            array(true,'file1.txt'),
            array(true,'file2.txt'),
        );

        $oDir=new _dir($this->getDirname());
        $tList=$oDir->getListFile();

        $bOk=true;

        $tError=array();

        foreach ($tExpectedList as $tCheck) {
            if (false==$this->findItemInArray($tCheck, $tList)) {
                $tError[]= $tCheck[1]." not found";
                $bOk=false;
            }
        }

        $this->assertTrue($bOk, 'errors: '.implode("\n", $tError));
    }

    public function test_getListDirShouldFinishOk()
    {
        $tExpectedList=array(

            array(false,'subDirTest1'),
            array(false,'subDirTest2'),
        );

        $oDir=new _dir($this->getDirname());
        $tList=$oDir->getListDir();

        $bOk=true;

        $tError=array();

        foreach ($tExpectedList as $tCheck) {
            if (false==$this->findItemInArray($tCheck, $tList)) {
                $tError[]= $tCheck[1]." not found";
                $bOk=false;
            }
        }

        $this->assertTrue($bOk, 'errors: '.implode("\n", $tError));
    }
}
