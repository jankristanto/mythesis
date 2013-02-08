<?php
  class FormalWordsController extends AppController{
      public $name = 'FormalWords'; 
      
      public $paginate = array(
        'limit' => 25
      );
      
      public function index(){
          $data = $this->paginate('FormalWord');
          $this->set('data', $data);
      }
      
      public function getSen($word){
          debug($this->FormalWord->extract($word)); exit;
          
      }
      
      public function cari(){
          
      }
      
      public function  test(){
          $this->FormalWord->recursive = -1;
          //$sentiments = $this->FormalWord->find('all', array( 'conditions' => array("not" => array ( "FormalWord.status" => null))));
          
          $sentiments = $this->FormalWord->find('all', array( 'conditions' => array( "FormalWord.status" => 'positif')));
          foreach($sentiments as $senti){
              if($this->FormalWord->extract($senti['FormalWord']['text'])<0){
                  
                  debug($senti);
              }
              
          }
          
          exit;

          
      }
      
      public function search(){
       
           Configure::write ( 'debug', 0 );
            $this->autoRender=false;
            $words=$this->FormalWord->find("all",array("conditions"=> "text LIKE '".$_GET['term']."%'" ));
                $i=0;
                foreach($words as $word){
                    $response[$i]['value']=$word['FormalWord']['id'];
                    $response[$i]['label']=$word['FormalWord']['text'];
                $i++;
                }
            echo json_encode($response);
        
      }
      
  }
?>
