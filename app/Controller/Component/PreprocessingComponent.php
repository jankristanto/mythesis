<?php
  class PreprocessingComponent extends Component{
      
      public function casefolding($tweet){
          return strtolower($tweet);
      }
      
      public function clearInvalidUTF8($str){
            $str = iconv("UTF-8","UTF-8//IGNORE",$str); 
            $str = iconv("UTF-8","ISO-8859-1//IGNORE",$str);
            $str = iconv("ISO-8859-1","UTF-8",$str);
            return $str;
      }
      
      public function filterToken($splitedTweet){
           $tw = "";
           $this->InFormalWord = ClassRegistry::init('InFormalWord');
           $aspal = $this->InFormalWord->find('list',array(
			'fields' => array('InFormalWord.aspal', 'InFormalWord.asli')));
			//debug($splitedTweet);exit;
			foreach($splitedTweet as $word){
				if(strpos($word, "://") === FALSE && strpos($word, "@") === FALSE){
					$word = $this->removeSymbol($word); 
									
					if(isset($aspal[$word])){
						$word = $this->changeWord($aspal[$word]);
					}
					
					$word= $this->processNumbers($word);
					$word = trim($word);
					$word = $this->removeOneChar($word);
					$tw .= $word.' ';    
				}
			}
          
          return $tw;
      }
	  
	  public function removeOneChar($word){
		if (!is_numeric($word)){
			if(strlen($word) == 1){
				$word = '';
			}
		}
		return $word;
	  }
      
      public function changeWord($idAsli){
            $kata = $this->InFormalWord->FormalWord->findById($idAsli);   
            return $kata['FormalWord']['text'];
      }
      
      public function removeSymbol($word){
          /*$word = str_replace("!"," ",$word);
          $word = str_replace("*"," ",$word);
          $word = str_replace("^"," ",$word);
          $word = str_replace(","," ",$word);
		  $word = str_replace("."," ",$word);
		  $word = str_replace("#"," ",$word);
		  $word = str_replace(":"," ",$word);
		  $word = str_replace("="," ",$word);
		  $word = str_replace("-"," ",$word);
		  $word = str_replace("?"," ",$word);
		  $word = str_replace("rt"," ",$word);
		  $word = str_replace("("," ",$word);
		  $word = str_replace(")"," ",$word);
		  $word = str_replace("|"," ",$word); */
		  $word = preg_replace('/[^\p{L}\p{N}\s]/u',' ', $word);
		  if($word == 'rt'){$word='';}

          return $word;
      }
      
      public function doIt($tweet){
          $tweet = $this->clearInvalidUTF8($tweet);
          $splited = split(" ",$this->casefolding($tweet)); 
          
			return $this->filterToken($splited);
		   /*if(!in_array("rt", $splited)) {
				return $this->filterToken($splited);
			}else{
				return null;
			}*/
          
      }
	  
	        
      public function processNumbers($word){
         $pos = strpos($word,'2'); 
         if( $pos== TRUE){      
            $word = substr($word, 0, $pos).' '.substr($word, 0, $pos );  
          }
          return $word;
      }
  }
?>
