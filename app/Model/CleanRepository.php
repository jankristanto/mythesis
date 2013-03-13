<?php 
    class CleanRepository extends AppModel{
        public $useTable = 'clean_repositori'; 
        //public $useDbConfig = 'my';
        public $belongsTo = array(
            'Repository' => array(
                'className'    => 'Repository',
                'foreignKey'   => 'repositori_id'
            )
        );
    }
?>