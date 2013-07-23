<?php
  class Tweet extends AppModel{
      public $hasOne = array('CleanTweet');
	  public $belongsTo = array('Hunt');
	  
	  public function getBySentiment($idHunt,$sentiment){
		return $this->find('all',
				array('conditions' => array(
					'Tweet.hunt_id' => $idHunt,
					'CleanTweet.sentiment' => $sentiment
				))
			);
	  }
	  public function saveTweet($data,$huntId){
		$entry = array();
        $i = 0;
        $vowels = array("T", "Z");
		foreach($data as $d){
			//$da = str_replace($vowels, " ", $d['created_at']);
			$entry[$i]['published'] = date("Y-m-d H:i:s", strtotime($d['created_at']));
			$entry[$i]['content'] = $d['text'];
			$entry[$i]['link_tweet'] = $d['id_str'];
			$entry[$i]['avatar_image_link'] = $d['user']['profile_image_url'];
			$entry[$i]['content_html'] = $d['text'];
			$entry[$i]['author_name'] = $d['user']['name'];
			$entry[$i]['author_link'] = $d['user']['id_str'];
			$entry[$i]['source'] = $d['source'];
			$entry[$i]['hunt_id'] = $huntId;
			$i++;
		}
        
        //debug($entry); exit;
        if($this->saveAll($entry)){
			return true;
		}else{
			return false;
		} 
	  }
  }
?>
