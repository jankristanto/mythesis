<?php
  class FormalWordsController extends AppController{
      public $name = 'FormalWords'; 
      
      public $paginate = array(
        'limit' => 25
      );
	  
	  public function coba(){
		$data = $this->FormalWord->find('list',
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
		debug($data); exit;
	  }
	  public function generateText(){
		$this->FormalWord->recursive = -1;
		$data = $this->FormalWord->find('all',array('fields' => array('text')));
		App::uses('Folder', 'Utility');
		App::uses('File', 'Utility');
		$dir = new Folder(WWW_ROOT.'files', true, 0755);
		$file = new File(WWW_ROOT.'files/dic.txt', true, 0644);
		foreach($data as $d){
			if($file->exists()){
					$file->append($d['FormalWord']['text'].' ');
				}
		}
		echo "done"; exit;
	  }
      
      public function index(){
          $data = $this->paginate('FormalWord');
		  if($this->request->is('ajax')){
			$this->layout = 'ajax';
			$data=$this->FormalWord->find("all",array("conditions"=> "text LIKE '".$_POST['term']."%'" ));   
		  }
          $this->set('data', $data);
      }
      public function add(){
          $pos = array(
            'NN'=>'NN','VB' => 'VB','JJ' => 'JJ','RB'=>'RB','IN' => 'IN',
            'MD' => 'MD','UH' => 'UH','CC' => 'CC','PR'=> 'PR','DT' => 'DT',
            'CK'=> 'CK','RP' => 'RP','a2' => 'a2'
          );
          if($this->request->is('post')){
              if($this->FormalWord->save($this->request->data)){
                  $this->Session->setFlash('Telah Berhasil Menambahkan Kata Baku Baru');
                  $this->redirect(array('action' => 'index'));
              }
          }
          
          $this->set(compact('pos'));
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
