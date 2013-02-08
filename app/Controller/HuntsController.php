<?php 
	class HuntsController extends AppController{
		public $name = 'Hunts'; 
		public $components = array(
			'Session',
			'MyTwitter' => array(
				'lang' => 'in'
			),
			'Preprocessing', 
			'JanPosTagging',
			'SentimentAnalysisLexiconBased',
			'Weight'
		);
		
		public function index(){
			if($this->request->is('post')){
				// save keyword to db 
				$term = $this->request->data['Hunt']['keyword'];
				//debug($this->request->data); exit;
				if($this->Hunt->save($this->request->data)){
					// do crawl twitter
					$d = $this->MyTwitter->getAllTweets($term,1);
					
					if($this->Hunt->Tweet->saveTweet($d,$this->Hunt->id )){
						//$this->Session->setFlash(' Tweet dengan term '.$term.' telah disimpan');
						$this->redirect(array('action' => 'view', $this->Hunt->id));
					}else{
						$this->Session->setFlash(' Pencarian dengan term '.$term.' gagal disimpan');
					}
				}
			}
		}
		
		public function view($id){
			$this->paginate = array('Tweet'=>array('limit' => 20));
			
			$hunt = $this->paginate($this->Hunt->Tweet, 
				array('Hunt.id'=> $id)
			);
			
			$this->set(compact('hunt'));
		}
		
		public function preprocessing($page){
			$dataTweet = $this->Hunt->Tweet->find('all',array('limit' => 200,'page'=> $page));
			//$dataTweet = $this->Tweet->find('all');
			//debug($dataTweet); exit;
			$cleanTweets = array();
			foreach($dataTweet as $index => $tw){
				$cleanTweets[$index]['CleanTweet']['content'] = $this->Preprocessing->doIt($tw['Tweet']['content']);
				$cleanTweets[$index]['CleanTweet']['tweet_id'] = $tw['Tweet']['id'];
			}
				   
			if($this->Hunt-> Tweet->CleanTweet->saveAll($cleanTweets)){
				$this->redirect(array('controller' => 'CleanTweets','action' => 'index'));
			}
			
			
		}
		
		public function analisis($page){
        
			$this->Hunt->Tweet->CleanTweet->recursive = -1;
			$dataBersih = $this->Hunt->Tweet->CleanTweet->find('all',array('limit' => 200,'page'=> $page));
			//$dataBersih = $this->Tweet->CleanTweet->find('all');
			//debug($dataBersih); exit;
			$hasil = array();
			
			foreach($dataBersih as $index => $t){
				$hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
				$hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
				$hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
				$hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
				$this->Hunt->Tweet->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id']; 
				$this->Hunt->Tweet->CleanTweet->saveField('sentiment',$hasil['conclusion']);
			}
			$this->redirect(array('controller' => 'CleanTweets','action' => 'index'));
		}
		
		public function indexing(){
			$data = $this->Hunt->Tweet->CleanTweet->find('all');
			foreach($data as $d){
				$this->Weight->getTfidf($d); 
			}
			exit;
		}
	}
?>