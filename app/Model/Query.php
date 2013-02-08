<?php 
	class Query extends AppModel{
		public $useTable = 'query'; 
		public $useDbConfig = 'my';
		public $primaryKey = 'id_query';
		public $hasMany = array(
			'Repository' => array(
				'className' => 'Repository',
				'foreignKey' => 'id_query',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '10',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
		);
	}
?>