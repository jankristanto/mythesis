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
			'Weight',
			'JanSvm',
			'Twitteroauth.Twitter'
		);
		
		public function t(){
			$result = Set::reverse($this->Twitter->OAuth->get(
				'search/tweets', array('q' => 'wiranto','lang'=> 'in','count' => 100)
			));
			debug($result); exit; 
		}
        
        public function result($id){
			$list = $this->Hunt->Tweet->CleanTweet->Sentiment->find('list',array('fields' => array('clean_tweet_id','sentiment'))); 
			$this->set('manual',$list); 
			$this->Hunt->recursive = -1; 
            $data = $this->Hunt->read(null,$id);
			$positive = $this->Hunt->Tweet->getBySentiment($id,'positif');
			$negative = $this->Hunt->Tweet->getBySentiment($id,'negatif');
			$neutral = $this->Hunt->Tweet->getBySentiment($id,'netral');
            $this->set(compact('data','positive','negative','neutral')); 
        }
		public function service(){
			if($this->request->is('post')){
				$hunt['Hunt']['keyword'] = $this->data['Hunt']['keyword'];
				// simpan kata kunci 
				if($this->Hunt->save($hunt)){
					// mencari data pada twitter
					$d = $this->MyTwitter->getAllTweets($hunt['Hunt']['keyword'],1);
					// menyimpan data tweet
					if($this->Hunt->Tweet->saveTweet($d['statuses'],$this->Hunt->id )){
						$this->Hunt->Tweet->recursive = -1;
						// ambil data yang didapat
						$dataTweet = $this->Hunt->Tweet->find('all',array(
							'conditions' => array(
								'Tweet.hunt_id' => $this->Hunt->id
							)
						));
						// ambil kata tidak baku 
						$informalword = ClassRegistry::init('InFormalWord');
						$aliaswords = $kata = $informalword->find('list',array(
								'fields' => array('InFormalWord.aspal','FormalWord.text'),
								'recursive' => 1
								)
							);
						// lakukan preprocessing
						$cleanTweets = array();
						foreach($dataTweet as $index => $tw){
							$clean = $this->Preprocessing->doIt($tw['Tweet']['content'],$aliaswords);
							if(!is_null($clean)){
								$cleanTweets[$index]['CleanTweet']['content'] = $clean;
								$cleanTweets[$index]['CleanTweet']['tweet_id'] = $tw['Tweet']['id'];
							}
							
						}
						// simpan data yang sudah di preprocessing	   
						if($this->Hunt->Tweet->CleanTweet->saveAll($cleanTweets)){
							$this->Hunt->Tweet->CleanTweet->recursive = -1;
							$dataBersih = $this->Hunt->Tweet->CleanTweet->getCleanTweet($this->Hunt->id);
							$hasil = array();
							$formalWord = ClassRegistry::init('FormalWord');
							$sentimentword = $formalWord->listSentimentWord();
							// postagging dan unsupervised labeled 	
							foreach($dataBersih as $index => $t){
								$hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
								$hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->checkSentiment($hasil,$sentimentword);
								
								if(!$hasil['conclusion']){  
									$this->Hunt->Tweet->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id'];
									$this->Hunt->Tweet->CleanTweet->saveField('sentiment','netral'); 
								}
								
							}
							$data = $this->Hunt->Tweet->CleanTweet->getCleanTweetNotNetral($this->Hunt->id);
							// generate data vector test 
							$this->Weight->buildTestingData($data);
							// labeled dengan SVM 
							$this->JanSvm->test('jan.test','jan.train.model','jan.out');
	        
							$this->Hunt->Tweet->CleanTweet->recursive = -1;
							//debug($result); exit;
							$data = $this->Hunt->Tweet->CleanTweet->getCleanTweetNotNetral($this->Hunt->id);
							$lines=array();
							
							$fp=fopen(WWW_ROOT.'files/jan.out', 'r');
							while (!feof($fp)){
								$line=fgets($fp);
								$line=trim($line);
								$lines[]=$line;

							}
							fclose($fp);
							// simpan hasil label 
							$hasil['positif'] = 0;
							$hasil['negatif'] = 0;
							foreach($data as $i => $d){
								if($lines[$i] > 0){
									$hasil['positif'] += 1; 
									$this->Hunt->Tweet->CleanTweet->id = $d['CleanTweet']['id']; 
									$this->Hunt->Tweet->CleanTweet->saveField('sentiment','positif');    
								}else{
									$hasil['negatif'] += 1;
									$this->Hunt->Tweet->CleanTweet->id = $d['CleanTweet']['id']; 
									$this->Hunt->Tweet->CleanTweet->saveField('sentiment','negatif');    
								}    
								
							}
							$this->redirect(array('controller' => 'hunts','action' => 'result',$this->Hunt->id));
						}
					}else{
						echo "Gagal Menyimpan data tweet"; exit;
					}
					
				}
			}
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
					$kembalian['jumlah'] = count($d['statuses']);
					if($this->Hunt->Tweet->saveTweet($d['statuses'],$this->Hunt->id )){
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