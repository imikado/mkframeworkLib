<?php
class _file
{
		public static $testui_getTab=null;
		public static $testui_written=null;

		protected $sFilename;

		public function __construct($sFilename_){
			$this->sFilename=$sFilename_;
		}

		public function getName(){
			return $this->sFilename;
		}

		public function getAdresse(){
			return $this->sFilename;
		}

		public static function reset(){
			self::$testui_getTab=null;
			self::$testui_written=null;
		}

    public function exist()
    {
    }
    public function write($sText)
    {
			self::$testui_written=$sText;
    }
		public function getTab(){
			if(self::$testui_getTab){
				return self::$testui_getTab;
			}
		}
}
