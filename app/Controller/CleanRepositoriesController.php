<?php
App::uses('AppController', 'Controller');
class CleanRepositoriesController extends AppController {
     public $components = array(
        'JanPosTagging',
        'SentimentAnalysisLexiconBased'
    );
    
     public function index(){
         debug($this->CleanRepository->Repository->find('all',array('limit' => 10)));exit;
         
     }
     
     public function analisys($limit,$after){
        $this->CleanRepository->recursive = -1;
		
        //$dataBersih = $this->CleanRepository->find('all',array('limit' => $limit,'page'=> $page));
        $dataBersih = $this->CleanRepository->query(
		"SELECT *
		FROM clean_repositori AS CleanRepository
		LIMIT ".$after." , ".$limit
		);
        $hasil = array();
        
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanRepository']['content'],$dataBersih[$index]['CleanRepository']['id']);
            $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
            $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
            $this->CleanRepository->id = $dataBersih[$index]['CleanRepository']['id']; 
            $this->CleanRepository->saveField('sentiment',$hasil['conclusion']);
        }
        $this->set(compact('limit','after'));
        
    }
    
    public function statistik(){
        $data = $this->CleanRepository->find('all',array('fields' => array('COUNT(id) AS jum','sentiment'),'group' => array('CleanRepository.sentiment'))); 
        $this->CleanRepository->Repository->recursive = -1;
		$count = $this->CleanRepository->Repository->find('count');
		$this->set(compact('data','count'));
        
        
    }
}
