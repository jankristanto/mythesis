<?php 
	class TweetsController extends AppController{
		public $name = 'Tweets'; 
		
		public $components = array(
			'Preprocessing', 
		);
		
		public function preprocessing($huntId){
			$this->Tweet->recursive = -1;
			$dataTweet = $this->Tweet->find('all',array(
				'conditions' => array(
					'Tweet.hunt_id' => $huntId
				)
			));
			$informalword = ClassRegistry::init('InFormalWord');
			$aliaswords = $kata = $informalword->find('list',array(
					'fields' => array('InFormalWord.aspal','FormalWord.text'),
					'recursive' => 1
					)
				);
			//debug($dataTweet); exit;
			$cleanTweets = array();
			foreach($dataTweet as $index => $tw){
				$clean = $this->Preprocessing->doIt($tw['Tweet']['content'],$aliaswords);
				if(!is_null($clean)){
					$cleanTweets[$index]['CleanTweet']['content'] = $clean;
					$cleanTweets[$index]['CleanTweet']['tweet_id'] = $tw['Tweet']['id'];
				}
				
			}
				   
			if($this->Tweet->CleanTweet->saveAll($cleanTweets)){
				$this->redirect(array('controller' => 'CleanTweets','action' => 'index',$huntId));
			}
		}
		
	}
?>