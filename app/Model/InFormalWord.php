<?php
  class InFormalWord extends AppModel{
      public $name = 'InFormalWord'; 
      public $useTable = 'alias';
      public  $belongsTo = array(
        'FormalWord' => array(
            'foreignKey'   => 'asli'
        )
      );
      
      public $validate = array(
        'aspal' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => 'Please enter title',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => 'This category has already been taken.',
                //'allowEmpty' => false,
                //'required' => false,
                //'last' => false, // Stop validation after this rule
                //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'characters' => array(
                'rule' => array('custom', '/^[a-z0-9 ]*$/i'),
                'message' => 'Contain Illegal Characters',
            )
        ),
    );
      
  }
?>
