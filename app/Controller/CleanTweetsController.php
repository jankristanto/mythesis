<?php
App::uses('AppController', 'Controller');
/**
 * CleanTweets Controller
 *
 * @property CleanTweet $CleanTweet
 */
class CleanTweetsController extends AppController {
	public $components = array(
		'JanPosTagging',
		'SentimentAnalysisLexiconBased',
		'Weight', 
		'JanSvm'
	);

    public function checkNetral($huntId){
        $this->CleanTweet->recursive = -1;
        $dataBersih = $this->CleanTweet->getCleanTweet($huntId);
        $hasil = array();
        $formalWord = ClassRegistry::init('FormalWord');
		$sentimentword = $formalWord->listSentimentWord();
			
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->checkSentiment($hasil,$sentimentword);
            //debug($hasil); exit;
            
            if(!$hasil['conclusion']){  
                $this->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id'];
                $this->CleanTweet->saveField('sentiment','netral'); 
            }
            
        }
        $this->redirect(array('controller' => 'CleanTweets','action' => 'index',$huntId));    
    }
	
	
	public function sync(){
		$this->CleanTweet->Tweet->Hunt->recursive = -1;
		$id = $this->CleanTweet->Tweet->Hunt->find('first',array('fields' => array('id'),'order' => array('Hunt.id' => 'desc')));
		
		$this->CleanTweet->recursive = -1;
		
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->table,
                    'alias' => $this->CleanTweet->Tweet->alias,
                    'type' => 'left',
                    'foreignKey' => 'tweet_id',
					'conditions'=> 'Tweet.id =  CleanTweet.tweet_id'
                );	
		
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->Hunt->table,
                    'alias' => $this->CleanTweet->Tweet->Hunt->alias,
                    'type' => 'left',
                    'foreignKey' => 'hunt_id',
					'conditions'=> 'Tweet.hunt_id = Hunt.id'
                ); 
		
		$conditions = array('Tweet.hunt_id' => $id['Hunt']['id'],'CleanTweet.sentiment <>' => 'netral');

		$data = $this->CleanTweet->find('all',array('joins' => $joins,'conditions'=> $conditions));
		
		
		debug($data); exit;
	}
	public function train(){
		$this->JanSvm->train('jan.train','jan.train.model');
	}
	public function test($id){
		//debug($id); exit;
		$this->JanSvm->test('jan.test','jan.train.model','jan.out');
        
		$this->CleanTweet->recursive = -1;
        //debug($result); exit;
        $data = $this->CleanTweet->getCleanTweetNotNetral($id);
		$lines=array();
		
		$fp=fopen(WWW_ROOT.'files/jan.out', 'r');
		while (!feof($fp)){
			$line=fgets($fp);
			$line=trim($line);
			$lines[]=$line;

		}
		fclose($fp);
		
        $hasil['positif'] = 0;
        $hasil['negatif'] = 0;
        foreach($data as $i => $d){
            if($lines[$i] > 0){
                $hasil['positif'] += 1; 
                $this->CleanTweet->id = $d['CleanTweet']['id']; 
                $this->CleanTweet->saveField('sentiment','positif');    
            }else{
                $hasil['negatif'] += 1;
                $this->CleanTweet->id = $d['CleanTweet']['id']; 
                $this->CleanTweet->saveField('sentiment','negatif');    
            }    
            
        }
		$this->redirect(array('controller' => 'hunts','action' => 'result',$id));
        //$this->set('hasil', $hasil);
        
	}
	
	public function buildTrainingData(){
		$this->Weight->buildTrainingData();
		exit;
	}
	
	public function reTraining(){
		$this->Weight->buildTestingData();
		//$this->JanSvm->train('jan.train','jan.train.model');
		exit;
	}
	
	public function generateBobot($id){
		//debug($this->CleanTweet->getCleanTweet($id));
		$data = $this->CleanTweet->getCleanTweetNotNetral($id);
		//debug($data); exit;
		$this->Weight->buildTestingData($data);
		$this->Session->setFlash('Data Testing telah dibuat','default',array('class' => 'alert alert-info'));
		$this->redirect(array('action' => 'index',$id));
	}
    
    public function analisisForTest($idHunt){
        $dataBersih  = $this->CleanTweet->getCleanTweet($idHunt);
        $hasil = array();
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
            $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
            $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
            if($hasil['conclusion'] == 'netral'){
                $this->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id']; 
                $this->CleanTweet->saveField('sentiment',$hasil['conclusion']);   
            }
        }
        return $this->generateBobot($idHunt);
    }
	
	public function analisis($id){
		$this->CleanTweet->recursive = -1;
		//$this->CleanTweet->Behaviors->attach('Containable');
		$this->set('status', array(
			'netral' => 'netral',
			'positif' => 'positif',
			'negatif' => 'negatif'
			));
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->table,
                    'alias' => $this->CleanTweet->Tweet->alias,
                    'type' => 'left',
                    'foreignKey' => 'tweet_id',
					'conditions'=> 'Tweet.id =  CleanTweet.tweet_id'
                );	
		
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->Hunt->table,
                    'alias' => $this->CleanTweet->Tweet->Hunt->alias,
                    'type' => 'left',
                    'foreignKey' => 'hunt_id',
					'conditions'=> 'Tweet.hunt_id = Hunt.id'
                ); 
		
		$conditions = array('Tweet.hunt_id' => $id);

		$dataBersih = $this->CleanTweet->find('all',array('joins' => $joins,'conditions'=> $conditions));
		
		$hasil = array();
		
		foreach($dataBersih as $index => $t){
			$hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
			$hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
			$hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
			$hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
			$this->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id']; 
			$this->CleanTweet->saveField('sentiment',$hasil['conclusion']);
		}
		$this->redirect(array('controller' => 'CleanTweets','action' => 'index',$id));
		
	}
	
	public function manualsentiment(){
		$this->autoRender = false; 
		$sentiment = $_POST['sentiment']; 
		$id = $_POST['id']; 
		$check = $this->CleanTweet->Sentiment->find('count',array('conditions' => array('clean_tweet_id' => $id)));
		if($check > 0){
			$this->CleanTweet->Sentiment->updateSentiment($id,$sentiment);
		}else{
			$this->CleanTweet->Sentiment->insertSentiment($id,$sentiment);
		}
	}
	
	public function statistik(){
		$positifpositif1 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment IS NULL AND CleanTweet.sentiment = 'positif'"
		));
		$positifpositif2 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'positif' AND CleanTweet.sentiment = 'positif'"
		));
		$positifpositif = $positifpositif1 + $positifpositif2;
		
		$positifnetral = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'netral' AND CleanTweet.sentiment = 'positif'"
		));		
		$positifnegatif = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'negatif' AND CleanTweet.sentiment = 'positif'"
		));
		/* end positif */
		$netralnetral1 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment IS NULL AND CleanTweet.sentiment = 'netral'"
		));
		$netralnetral2 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'netral' AND CleanTweet.sentiment = 'netral'"
		));		
		$netralnetral = $netralnetral1 + $netralnetral2;
		
		$netralpositif = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'positif' AND CleanTweet.sentiment = 'netral'"
		));
		$netralnegatif = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'negatif' AND CleanTweet.sentiment = 'netral'"
		));
		/* end netral */
		$negatifnegatif1 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment IS NULL AND CleanTweet.sentiment = 'negatif'"
		));
		$negatifnegatif2 = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'negatif' AND CleanTweet.sentiment = 'negatif'"
		));		
		$negatifnegatif =  $negatifnegatif1 + $negatifnegatif2;
		$negatifpositif = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'positif' AND CleanTweet.sentiment = 'negatif'"
		));
		$negatifnetral = $this->CleanTweet->find('count', array(
			'conditions' => "Sentiment.sentiment = 'netral' AND CleanTweet.sentiment = 'negatif'"
		));
		$this->set(compact(
			'positifpositif','positifnetral','positifnegatif',
			'netralpositif','netralnetral','netralnegatif',
			'negatifpositif','negatifnetral','negatifnegatif'
		));
	}
/**
 * index method
 *
 * @return void
 */
	public function index($id) {
		$this->CleanTweet->recursive = -1;
		//$this->CleanTweet->Behaviors->attach('Containable');
		$this->set('status', array(
			'netral' => 'netral',
			'positif' => 'positif',
			'negatif' => 'negatif'
			));
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->table,
                    'alias' => $this->CleanTweet->Tweet->alias,
                    'type' => 'left',
                    'foreignKey' => 'tweet_id',
					'conditions'=> 'Tweet.id =  CleanTweet.tweet_id'
                );	
		
		$joins[] = array(
                    'table' => $this->CleanTweet->Tweet->Hunt->table,
                    'alias' => $this->CleanTweet->Tweet->Hunt->alias,
                    'type' => 'left',
                    'foreignKey' => 'hunt_id',
					'conditions'=> 'Tweet.hunt_id = Hunt.id'
                ); 
		$this->paginate = array(
			'fields' => array('Tweet.*','CleanTweet.*') ,
			'joins' => $joins,
			'conditions' => array('Tweet.hunt_id' => $id),
			'limit' => 10
		);
		
		
		$cleanTweets = $this->paginate('CleanTweet');
		//debug($cleanTweets); exit;
		$this->set('huntId',$id);
		$this->set('cleanTweets', $cleanTweets);
	}

/**
 * view method
 *
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->CleanTweet->id = $id;
		if (!$this->CleanTweet->exists()) {
			throw new NotFoundException(__('Invalid clean tweet'));
		}
		
		$this->set('cleanTweet', $this->CleanTweet->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->CleanTweet->create();
			if ($this->CleanTweet->save($this->request->data)) {
				$this->Session->setFlash(__('The clean tweet has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clean tweet could not be saved. Please, try again.'));
			}
		}
		$tweets = $this->CleanTweet->Tweet->find('list');
		$this->set(compact('tweets'));
	}

/**
 * edit method
 *
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->CleanTweet->id = $id;
		if (!$this->CleanTweet->exists()) {
			throw new NotFoundException(__('Invalid clean tweet'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->CleanTweet->save($this->request->data)) {
				$this->Session->setFlash(__('The clean tweet has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The clean tweet could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->CleanTweet->read(null, $id);
		}
		$tweets = $this->CleanTweet->Tweet->find('list');
		$this->set(compact('tweets'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->CleanTweet->id = $id;
		if (!$this->CleanTweet->exists()) {
			throw new NotFoundException(__('Invalid clean tweet'));
		}
		if ($this->CleanTweet->delete()) {
			$this->Session->setFlash(__('Clean tweet deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Clean tweet was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function updatesentiment(){
		$this->layout = 'ajax'; 
		$this->autoRender = false; 
		$this->CleanTweet->id = $this->data['id']; 
		if($this->CleanTweet->saveField('sentiment',$this->data['sentiment'])){
			echo "berhasil";
		}else{
			echo "gagal";
		}
		
		exit;
	}
	
}
