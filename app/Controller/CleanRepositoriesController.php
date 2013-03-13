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
     
     public function analisys($limit,$page){
        $this->CleanRepository->recursive = -1;
        $dataBersih = $this->CleanRepository->find('all',array('limit' => $limit,'page'=> $page));
        
        $hasil = array();
        
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanRepository']['content'],$dataBersih[$index]['CleanRepository']['id']);
            $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
            $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
            $this->CleanRepository->id = $dataBersih[$index]['CleanRepository']['id']; 
            $this->CleanRepository->saveField('sentiment',$hasil['conclusion']);
        }
        $this->set(compact('limit','page'));
        
    }
}
