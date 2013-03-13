<?php 
	class Repository extends AppModel{
		public $useTable = 'repositori'; 
		//public $useDbConfig = 'my';
		public $primaryKey = 'id_repositori';
        public $hasOne = array('CleanRepository');
	}
?>