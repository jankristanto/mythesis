<?php 
	class TweetsController extends AppController{
		public $name = 'Tweets'; 
		
		public $components = array(
			'Preprocessing', 
		);
		
		public function preprocessing($huntId){
			$dataTweet = $this->Tweet->find('all',array(
				'conditions' => array(
					'Tweet.hunt_id' => $huntId
				)
			));
			//$dataTweet = $this->Tweet->find('all');
			//debug($dataTweet); exit;
			$cleanTweets = array();
			foreach($dataTweet as $index => $tw){
				$clean = $this->Preprocessing->doIt($tw['Tweet']['content']);
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