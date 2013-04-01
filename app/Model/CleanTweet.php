<?php
  Class CleanTweet extends AppModel{
      public $name = 'CleanTweet'; 
      
      public $belongsTo = array('Tweet');
      
      public function getCleanTweet($id){
        $this->recursive = -1;
        $joins[] = array(
                    'table' => $this->Tweet->table,
                    'alias' => $this->Tweet->alias,
                    'type' => 'left',
                    'foreignKey' => 'tweet_id',
                    'conditions'=> 'Tweet.id =  CleanTweet.tweet_id'
                );    
        
        $joins[] = array(
                    'table' => $this->Tweet->Hunt->table,
                    'alias' => $this->Tweet->Hunt->alias,
                    'type' => 'left',
                    'foreignKey' => 'hunt_id',
                    'conditions'=> 'Tweet.hunt_id = Hunt.id'
                ); 
        
        $conditions = array('Tweet.hunt_id' => $id);

        return $this->find('all',array('joins' => $joins,'conditions'=> $conditions));
          
      }
	  
	  public function getCleanTweetNotNetral($id){
        $this->recursive = -1;
        $joins[] = array(
                    'table' => $this->Tweet->table,
                    'alias' => $this->Tweet->alias,
                    'type' => 'left',
                    'foreignKey' => 'tweet_id',
                    'conditions'=> 'Tweet.id =  CleanTweet.tweet_id'
                );    
        
        $joins[] = array(
                    'table' => $this->Tweet->Hunt->table,
                    'alias' => $this->Tweet->Hunt->alias,
                    'type' => 'left',
                    'foreignKey' => 'hunt_id',
                    'conditions'=> 'Tweet.hunt_id = Hunt.id'
                ); 
        
        $conditions = array('Tweet.hunt_id' => $id,'CleanTweet.sentiment' => null);

        return $this->find('all',array('joins' => $joins,'conditions'=> $conditions));
          
      }
  }
?>
