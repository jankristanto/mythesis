<?php
  class FormalWord extends AppModel{
      public $name = 'FormalWord'; 
      public $useTable = 'kelas_kata';
      public $hasMany = array(
        'InFormalWord' => array(
            'foreignKey'   => 'asli'
        )
      );
	  
	  public function listSentimentWord(){
		return $this->find('list',
			array(
				'fields' => array('text','status'), 
				'conditions' => array(
					'OR' => array(
						'pos' => 'VB',
						'pos' => 'JJ',
					)
				)
			)
		);
	  }

      public function extract($word,$pos=null){
          $score = 0.0;
          if(is_null($pos)){
              $queryStr = "
                SELECT * FROM 
                kelas_kata AS IND 
                LEFT JOIN senti as ENG 
                ON ((IND.en = ENG.word) AND IND.pos = ENG.pos )
                WHERE IND.text = '".$word."'
              ";
              
              $results = $this->query($queryStr);
              
              foreach($results as $result){
                $score += $result['ENG']['PosScore']  - $result['ENG']['NegScore'];
                  
              }
              
              if(count($results) > 0){
                $score /= count($results);    
              }else{
                  $score = 0;
              }
              
          }
          return $score;
      }
  }
?>
