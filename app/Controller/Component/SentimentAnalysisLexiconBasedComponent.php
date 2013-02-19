<?php
	require_once(APP . 'Vendor' . DS.'IDNstemmer.php');
  Class SentimentAnalysisLexiconBasedComponent extends Component{
      public $FormalWord;
	  public $streamer;
      public function initialize(Controller $controller){
           
      }
    
      public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
            $this->Controller = $collection->getController();
            $this->FormalWord = ClassRegistry::init('FormalWord');
			$this->streamer = new IDNstemmer();
            parent::__construct($collection, $settings);
      }
      
      public function analysisTwoWord($one,$two){
        
        $this->FormalWord->recursive = -1;
        $sentimenOne = $this->FormalWord->find('first',array('conditions' => array('text' => $this->streamWord($one['word']))));    
        $sentimenTwo = $this->FormalWord->find('first',array('conditions' => array('text' => $this->streamWord($two['word']))));  
        
        if($sentimenOne['FormalWord']['status'] == $sentimenTwo['FormalWord']['status']){
            return $sentimenOne['FormalWord']['status'];
        }else{
            if(($sentimenOne['FormalWord']['status'] == 'netral' || $sentimenOne == false
            || $sentimenOne['FormalWord']['status'] == null) &&  $sentimenTwo['FormalWord']['status'] !=     'netral'){
                return $sentimenTwo['FormalWord']['status'];            
            }else{
                if(
                ($sentimenOne['FormalWord']['status'] != 'netral'  ) &&  
                ($sentimenTwo['FormalWord']['status'] == null || 
                $sentimenTwo['FormalWord']['status']== 'netral' || 
                $sentimenTwo == false
                )){
                    return $sentimenOne['FormalWord']['status'];            
                }else{
                    if(
                        $sentimenOne['FormalWord']['status'] != 'netral' &&
                        $sentimenTwo['FormalWord']['status'] != 'netral' &&
                        ($sentimenOne['FormalWord']['status'] == 'negatif' ||
                         $sentimenTwo['FormalWord']['status'] == 'negatif'
                        )
                    ){
                        return 'negatif';
                    }else{
                        return 'netral';
                    }
                }
            }
        }
      }
      
      public function analysisOneWord($one){
        $this->FormalWord->recursive = -1;
		
		
        $sentimenOne = $this->FormalWord->find('first',
            array('conditions' => array('text' => $this->streamWord($one['word']))));        
        return $sentimenOne['FormalWord']['status'];    
      }
	  
	  public function streamWord($word){
		/*if($this->FormalWord->find('count',
            array('conditions' => array('text' => $word))) > 0){
				return $word;
		}else{
			return $this->streamWord($word);
		}*/
		return $word;
	  }
      
      public function preliminaryAnalysis($sentence){
          $sentiments = array();
          
          /*foreach($sentence as $i => $kata){
              if($i>0){
              if(
                    ($sentence[$i]['jenis'] == 'VB') 
                    &&($sentence[$i-1]['jenis'] == 'RB' || $sentence[$i-1]['jenis'] == 'CK'
                       ||$sentence[$i-1]['jenis'] == 'NN' || $sentence[$i-1]['jenis'] == 'JJ' 
                    )
                  ){
                      
                      array_push(
                        $sentiments,
                        array(
                             'analysis' => $this->analysisTwoWord($sentence[$i-1],$sentence[$i]),
                            $sentence[$i-1],
                            $sentence[$i]
                        )
                      );
                  }else{
                      if(
                        ($sentence[$i]['jenis'] == 'JJ') && 
                        ($sentence[$i-1]['jenis'] == 'RB' || $sentence[$i-1]['jenis'] == 'NN'
                       ||$sentence[$i-1]['jenis'] == 'VB' 
                       )
                      ){
                         array_push(
                        $sentiments,
                        array(
                            'analysis' => $this->analysisTwoWord($sentence[$i-1],$sentence[$i]),
                            $sentence[$i-1],
                            $sentence[$i]
                        )
                      );
                      }else{
                          if($sentence[$i]['jenis'] == 'JJ' || $sentence[$i]['jenis'] == 'VB'){
                              // do analysis 1 word
                              array_push(
                                $sentiments,
                                array(
                                    'analysis' => $this->analysisOneWord($sentence[$i]), 
                                    $sentence[$i]
                                )
                              );
                          }
                      }
                  }
              }else{
                 if($sentence[$i]['jenis'] == 'JJ' || $sentence[$i]['jenis'] == 'VB'){
                              // do analysis 1 word
                    array_push(
                                $sentiments,
                                array(
                                    'analysis' => $this->analysisOneWord($sentence[$i]),
                                    $sentence[$i]
                                )
                              );
                 }                    
              }   
          }*/
          
          $i=0;
          while($i<(count($sentence))){
			
              if($i>0){
				if(
                    ($sentence[$i]['jenis'] == 'VB') 
                    &&($sentence[$i-1]['jenis'] == 'RB' || $sentence[$i-1]['jenis'] == 'CK'
                       ||$sentence[$i-1]['jenis'] == 'NN' || $sentence[$i-1]['jenis'] == 'JJ' 
                    )
                  ){
                      
                      array_push(
                        $sentiments,
                        array(
                             'analysis' => $this->analysisTwoWord($sentence[$i-1],$sentence[$i]),
                            $sentence[$i-1],
                            $sentence[$i]
                        )
                      );
                      
                  }else{
                      if(
                        ($sentence[$i]['jenis'] == 'JJ') && 
                        ($sentence[$i-1]['jenis'] == 'RB' || $sentence[$i-1]['jenis'] == 'NN'
                       ||$sentence[$i-1]['jenis'] == 'VB' 
                       )
                      ){
                         array_push(
                        $sentiments,
                        array(
                            'analysis' => $this->analysisTwoWord($sentence[$i-1],$sentence[$i]),
                            $sentence[$i-1],
                            $sentence[$i]
                        )
                      );
                      
                      }else{
                          if($sentence[$i]['jenis'] == 'JJ' || $sentence[$i]['jenis'] == 'VB'){
                              // do analysis 1 word
                              array_push(
                                $sentiments,
                                array(
                                    'analysis' => $this->analysisOneWord($sentence[$i]), 
                                    $sentence[$i]
                                )
                              );
                          }
                      }
                  }
              }else{
				
                 if($sentence[$i]['jenis'] == 'JJ' || $sentence[$i]['jenis'] == 'VB'){
                              // do analysis 1 word
							  
                    array_push(
							$sentiments,
							array(
								'analysis' => $this->analysisOneWord($sentence[$i]),
								$sentence[$i]
							)
						  );
					
                 }                    
              } 
              $i++;  
          }
          
          $senti = array();
          foreach($sentiments as $analysis){
              if(($analysis['analysis'] != null) ||  ($analysis['analysis'] != '') || (!empty($analysis['analysis']))){
                  $senti[] = $analysis;
              }
          }
          
          return $senti;
      }
      
      
      public function checkNegation($data){
	  
		$negation = $this->FormalWord->find('list',array('conditions' => array('status' => 'kontra'), 'fields' => array('FormalWord.text','FormalWord.text'))); 
		
            for ($i=0; $i< count($data['frase']); $i++){
                if($data['frase'][$i]['analysis'] != null){
                    $data['frase'][$i]['negation'] = false;
                    for($j=0; $j<count($data['frase'][$i]) -2;$j++){
                        for($k=1; $k<=5; $k++){
                           
                            if(($data['frase'][$i][$j]['urutan']-$k) >=0 ){
                                if(isset($negation[$data[$data['frase'][$i][$j]['urutan']-$k]['word']])){
                                    $data['frase'][$i]['negation'] = true;   
                                }                
                            }
                        }
                        
                    }
                }
            }
           return $data;
      }
      
      public function conclusion($frase){
          $positif = 0; 
          $negatif = 0; 
          
          foreach($frase as $f){
              
            if($f['analysis'] == 'positif'){// sentiment +
                
                if($f['negation']){ // negation true
                    $negatif++;
                }else{ // negation false;
                    $positif++;
                }
                
            }else{
                if($f['analysis'] == 'negatif'){//sentiment -
                    if($f['negation']){//negation true
                        $positif++;
                    }else{ // negation false
                        $negatif++;
                    }
                }
            }
          }
          
          $kesimpulan = '';
          if($positif > $negatif){
              $kesimpulan = 'positif';
          }else{
              if($positif < $negatif){
                  $kesimpulan = 'negatif';
              }else{
                  $kesimpulan = 'netral';
              }
          }
            
          return $kesimpulan;
      }
  }
?>
