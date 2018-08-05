<?php

require_once(__DIR__.'/../../inc/abstract/abstract_sgbd.php');


require_once(__DIR__.'/../../../sgbd/sgbd_json.php');

require_once(__DIR__.'/../../inc/sgbd/pdo/fakePdoFetch.php');


class row_json{
	protected $tData=array();
	public function __construct($tData){
		$this->tData=$tData;
	}

	public function __get($var){
		return $this->tData[$var];
	}
}


class fakeSgbdJson extends sgbd_json{

	protected $_sConfig='';
	protected $_tConfig=array();

	public function testui_Connect(){
		$this->connect();
	}
	public function testui_setConfig($tConfig_){
		$this->_tConfig=$tConfig_;
	}

	public function getConfig(){
		return $this->_sConfig;
	}

	public function erreur($sText){
		throw new Exception($sText);
	}
}

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class sgbd_jsonTest extends PHPUnit_Framework_TestCase
{
    public function run(PHPUnit_Framework_TestResult $result = null)
    {
        $this->setPreserveGlobalState(false);
        return parent::run($result);
    }

		private function trimString($sString_){
			return str_replace(array("\n","\r","\r","\t","\s",' '),'',$sString_);
		}

		public function test_getListColumnShouldFinishOk(){

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>'myDir'));

			$sException=null;
			try{
				$oPdo->getListColumn('myTable');
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegExp('/structure/',$sException);
		}

		public function test_getListTableShouldFinishOk(){
			require_once(__DIR__.'/../../inc/class_file.php');
			require_once(__DIR__.'/../../inc/class_dir.php');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>'myDir'));

			_dir::$testui_getList=array(new _dir('myTable1'),new _dir('myTable2') );

			$this->assertEquals(array('myTable1','myTable2'),$oPdo->getListTable());

		}


		public function test_getWhereAllShouldFinishOk(){
			$oPdo=new fakeSgbdJson();

			$this->assertEquals('1=1',$oPdo->getWhereAll());
		}

		public function test_getInstanceShouldFinishOk(){
			$oPdo=new fakeSgbdJson();

			$this->assertEquals('1=1',fakeSgbdJson::getInstance('myConfig')->getWhereAll() );
		}

		public function test_quoteShouldFinishOk(){
			$oPdo=new fakeSgbdJson();

			$this->assertEquals('val1',$oPdo->quote('val1'));
		}

		public function test_insertShouldFinishOk(){

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>'myDir'));

			$sException=null;
			try{
				$oPdo->insert('myTable',array('Field1'=>'val1','Field2'=>'val2'));
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegExp('/max/',$sException);
		}

		public function test_updateShouldFinishOk(){

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>'myDir/'));

			$sException=null;
			try{
				$oPdo->update('myTable',array('Field1'=>'val31','Field2'=>'val32'),array(2));
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegExp('/myDir\/myTable\/2\.json/',$sException);
		}

		public function test_deleteShouldFinishOk(){

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>'myDir/'));

			$sException=null;
			try{
				$oPdo->delete('myTable',array(2));
			}catch(Exception $e){
				$sException=$e->getMessage();
			}

			$this->assertRegExp('/myDir\/myTable\/2\.json/',$sException);
		}

		public function test_findOneShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable WHERE id=?',2);

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findOne($tSql,'row_json');

			$oExpectedRow=new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais'));

			$this->assertEquals($oExpectedRow,$oRow);
		}

		public function test_findOneAndShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable WHERE Nom=? AND Prenom=?','Asimov','Isaac');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findOne($tSql,'row_json');

			$oExpectedRow=new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais'));

			$this->assertEquals($oExpectedRow,$oRow);
		}

		public function test_findOneNullShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable WHERE id=?',999);

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findOne($tSql,'row_json');

			$oExpectedRow=null;

			$this->assertEquals($oExpectedRow,$oRow);
		}

		public function test_findManyShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findMany($tSql,'row_json');

			$tExpectedRow=array(
				new row_json(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
				new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
				new row_json(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais'))
			);

			$this->assertEquals($tExpectedRow,$oRow);
		}

		public function test_findManyOrderByShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable ORDER BY Nom ASC');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findMany($tSql,'row_json');

			$tExpectedRow=array(

				new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
				new row_json(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
				new row_json(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
			);

			$this->assertEquals($tExpectedRow,$oRow);
		}

		public function test_findManyOrderByDescShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable ORDER BY Nom DESC');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findMany($tSql,'row_json');

			$tExpectedRow=array(
				new row_json(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
				new row_json(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
				new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
			);

			$this->assertEquals($tExpectedRow,$oRow);
		}

		public function test_findManyWhereNotEqualShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT * FROM myTable WHERE Langue!=?','Anglais');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$oRow=$oPdo->findMany($tSql,'row_json');

			$tExpectedRow=array(
				new row_json(array('id'=>1,'Nom'=>'Hugo','Prenom'=>'Victor','Langue'=>'Francais')),
				new row_json(array('id'=>3,'Nom'=>'Camus','Prenom'=>'Albert','Langue'=>'Francais')),
				//new row_json(array('id'=>2,'Nom'=>'Asimov','Prenom'=>'Isaac','Langue'=>'Anglais')),
			);

			$this->assertEquals($tExpectedRow,$oRow);
		}

		public function test_findManyCountShouldFinishOk(){

			require_once(__DIR__.'/../../../class_file.php');
			require_once(__DIR__.'/../../../class_dir.php');

			$tSql=array('SELECT count(*) FROM myTable');

			$oPdo=new fakeSgbdJson();
			$oPdo->testui_setConfig(array('.database'=>__DIR__.'/../../data/db/json/'));

			$iCount=$oPdo->findMany($tSql,'row_json');

			$iExpectedRow=array(3);

			$this->assertEquals($iExpectedRow,$iCount);
		}

}
