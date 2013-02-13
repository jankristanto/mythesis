<?php
  require_once(APP . 'Vendor' . DS.'TextParse.class.php');
  class JanPosTaggingComponent extends Component{
      
      public $FormalWord;
      public function initialize(Controller $controller){
           
      }
    
      public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
            $this->FormalWord = ClassRegistry::init('FormalWord');
            $this->Controller = $collection->getController();
            parent::__construct($collection, $settings);
      }
	  
	  public function singlePostTag($kalimat){
		  $results = array();
          $parser = new TextParse($kalimat); 
          $toArray = $parser->getWord(1); 
          $this->FormalWord->recursive = -1;
          foreach($toArray as $index => $word){
              if($this->FormalWord->find('count',array(
                'conditions' => array('text' => $word)
              ))){
                  $baku = $this->FormalWord->find('first',array(
                'conditions' => array('text' => $word)));
                  array_push(
                    $results,array(
          
                        'urutan' => $index,
                        'word' => $word, 
                        'jenis' => $baku['FormalWord']['pos']
                    )
                  );
              }else{
                 array_push(
                    $results,array(
          
                        'urutan' => $index,
                        'word' => $word, 
                        'jenis' => 'NN'
                    )
                  ); 
                  
              }
              
          }
         return $results; 
	  }
      
      public function posTagDic($tweet,$id){
          $results = array();
          $parser = new TextParse($tweet); 
          $toArray = $parser->getWord(1); 
          $this->FormalWord->recursive = -1;
          foreach($toArray as $index => $word){
              if($this->FormalWord->find('count',array(
                'conditions' => array('text' => $word)
              ))){
                  $baku = $this->FormalWord->find('first',array(
                'conditions' => array('text' => $word)));
                  array_push(
                    $results,array(
                        'clean_tweet_id' => $id,
                        'urutan' => $index,
                        'word' => $word, 
                        'jenis' => $baku['FormalWord']['pos']
                    )
                  );
              }else{
                 array_push(
                    $results,array(
                        'clean_tweet_id' => $id,
                        'urutan' => $index,
                        'word' => $word, 
                        'jenis' => 'NN'
                    )
                  ); 
                  
              }
              
          }
         return $results;  
      }
      
      
  }
?>
