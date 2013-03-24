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
			foreach($d['feed']['entry'] as $ent){
				$da = str_replace($vowels, " ", $ent['published']);
				$entry[$i]['published'] = $da;
				$entry[$i]['content'] = $ent['title'];
				$entry[$i]['link_tweet'] = $ent['link'][0]['@href'];
				$entry[$i]['avatar_image_link'] = $ent['link'][1]['@href'];
				$entry[$i]['content_html'] = $ent['content']['@'];
				$entry[$i]['author_name'] = $ent['author']['name'];
				$entry[$i]['author_link'] = $ent['author']['uri'];
				$entry[$i]['source'] = $ent['twitter:source'];
				$entry[$i]['hunt_id'] = $huntId;
				$i++;
			}
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
