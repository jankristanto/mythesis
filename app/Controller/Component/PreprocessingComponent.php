<?php
App::uses('Component', 'Controller');
  class PreprocessingComponent extends Component{
		public $components = array('SpellingCorrection');
		public $dictonary;
		public $aliaswords;
		public $informalword; 
	  
		public function initialize(Controller $controller){
			$this->controller = $controller;
		}
		
		public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
			$this->informalword = ClassRegistry::init('InFormalWord');
			$this->aliaswords = $kata = $this->informalword->find('list',array(
					'fields' => array('InFormalWord.aspal','FormalWord.text'),
					'recursive' => 1
					)
				);
            parent::__construct($collection, $settings);
		}
		public function casefolding($tweet){
			return strtolower($tweet);
		}
      
		public function clearInvalidUTF8($str){
            $str = iconv("UTF-8","UTF-8//IGNORE",$str); 
            $str = iconv("UTF-8","ISO-8859-1//IGNORE",$str);
            $str = iconv("ISO-8859-1","UTF-8",$str);
            return $str;
		}
		
		public function mytrim($word,$i){
			if($i+2 < strlen($word)){
				if(($word[$i] == $word[$i+1]) && ($word[$i+1] == $word[$i+2])){
					$new_word = substr($word, 0,$i);
					$word = ($new_word . substr($word, $i+1));
					return $this->mytrim($word,$i);
				}
				return $this->mytrim($word,$i+1);
			}
			return $word;
		}
      
		public function filterToken($splitedTweet,$aspal){
			$tw = "";
			
			foreach($splitedTweet as $word){
				if(strpos($word, "://") === FALSE && strpos($word, "@") === FALSE){
					
					$word = $this->removeSymbol($word); 
					$word= $this->processNumbers($word);
					$word = trim($word);
					
					$word = $this->removeOneChar($word);
					
					
					$word = $this->mytrim($word,0);
					
					
					
					// change informal word
					if(isset($aspal[$word])){
						$word = $aspal[$word];
					}   
					$word = $this->correction($word);
					$tw .= $word.' ';
				}
			}
			return $tw;
		}
	  
	  public function correction($str){
		
		return $this->SpellingCorrection->correct($str,$this->controller->dictionary);
	  }
	  
	  public function removeOneChar($word){
		if (!is_numeric($word)){
			if(strlen($word) == 1){
				$word = '';
			}
		}
		return $word;
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
		  
          $aspal = $this->aliaswords;
		  return $this->filterToken($splited,$aspal);
		  
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
