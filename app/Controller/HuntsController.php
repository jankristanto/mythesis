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
        
        public function result($id){
			$this->Hunt->recursive = -1; 
            $data = $this->Hunt->read(null,$id);
			$positive = $this->Hunt->Tweet->getBySentiment($id,'positif');
			$negative = $this->Hunt->Tweet->getBySentiment($id,'negatif');
			$neutral = $this->Hunt->Tweet->getBySentiment($id,'netral');
            $this->set(compact('data','positive','negative','neutral')); 
        }
		
		public function index(){
			if($this->request->is('ajax')){
				$this->autoRender = false;
				$term = $_POST['keyword'];
				$hunt['Hunt']['keyword'] = $term;
				if($this->Hunt->save($hunt)){
					// do crawl twitter
					$d = $this->MyTwitter->getAllTweets($term,1);
                    //debug($d);
					$kembalian['jumlah'] = count($d[1]['feed']['entry']);
					if($this->Hunt->Tweet->saveTweet($d,$this->Hunt->id )){
				        $kembalian['status'] = 1;
                        $kembalian['hunt'] = $this->Hunt->id;
					}else{
                        $kembalian['status'] = 0;
					}
                    echo json_encode(array('data' => $kembalian));
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