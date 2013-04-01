<?php
App::uses('AppController', 'Controller');
class RepositoriesController extends AppController {
    public $components = array(
        'Preprocessing'
    );    
    
    public function index(){
		$limit = 50; 
		if(isset($this->params['named']['page'])){
			$page = $this->params['named']['page'];
		}else{
			$page = 1;
		}
		$this->set('data',$this->Repository->find('all',array(
				'limit' => $limit,'page' => $page
				
				)
			)
		);
    }
     
    public function preprocessingDataTraining($limit,$after){
		$informalword = ClassRegistry::init('InFormalWord');
		$aliaswords = $kata = $informalword->find('list',array(
					'fields' => array('InFormalWord.aspal','FormalWord.text'),
					'recursive' => 1
					)
				);
        //$dataTweet = $this->Repository->find('all',array('limit' => $limit,'page'=> $page));
		$dataTweet = $this->Repository->query("SELECT *
		FROM repositori AS Repository
		LIMIT ".$after." , ".$limit);
        $clean = array();
        ///debug($dataTweet); exit;
        foreach($dataTweet as $index => $tw){
            $clean[$index]['CleanRepository']['content'] = $this->Preprocessing->doIt($tw['Repository']['tweet'],$aliaswords);
            $clean[$index]['CleanRepository']['repositori_id'] = $tw['Repository']['id_repositori'];
        }
               
        
        if(!$this->Repository->CleanRepository->saveAll($clean)){
            $this->Session->setFlash('Gagal');
        }else{
            $this->set('jumlah',count($clean));
            $this->set(compact('after','limit'));
        }
    }
}
