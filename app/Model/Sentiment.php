<?php
	class Sentiment extends AppModel{
		public $belongsTo = array('CleanTweet');
		
		public function insertSentiment($idCleanTweet,$sentiment){
			$d = array(
				'Sentiment' => array(
					'clean_tweet_id' => $idCleanTweet, 
					'sentiment' => $sentiment
				)
			);
			return $this->save($d);
		}
	}
?>