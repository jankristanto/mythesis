<?php 
	class Hunt extends AppModel{
		public $name  = 'Hunt';
		public $hasMany = array('Tweet');
	}
?>