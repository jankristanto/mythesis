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
			/*$this->informalword = ClassRegistry::init('InFormalWord');
			$this->aliaswords = $kata = $this->informalword->find('list',array(
					'fields' => array('InFormalWord.aspal','FormalWord.text'),
					'recursive' => 1
					)
				); */
            parent::__construct($collection, $settings);
		}
		public function casefolding($tweet){
			return strtolower($tweet);
		}
      
		public function clearInvalidUTF8($str){
            $str = iconv("UTF-8","UTF-8//IGNORE",$str); 
            $str = iconv("UTF-8","ISO-8859-1//IGNORE",$str);
            $str = iconv("ISO-8859-1","UTF-8",$str);
			$str = (strlen($str) > 255) ? substr($str,0,255) : $str;
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
			//debug($splitedTweet);
			foreach($splitedTweet as $word){
				if(strpos($word, "://") === FALSE && strpos($word, "@") === FALSE){
					
					$word = $this->removeSymbol($word); 
					
					$word= $this->processNumbers($word);
					$word = $this->removeOneChar($word);
					$word = $this->mytrim($word,0);
														
					// change informal word
					if(isset($aspal[$word])){
						$word = $aspal[$word];
					}   
					/*if($word == 'wiranto'){
						$word = $this->correction($word);
						echo $word; exit;
					}*/
					if($word != ''){
						$word = $this->correction($word);
					}
					$tw .= $word.' ';
				}
			}
			//debug(trim($tw));exit;
			return trim($tw);
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

          return trim($word);
      }
      
      public function doIt($tweet,$aliaswords){
          $tweet = $this->clearInvalidUTF8($tweet);
		  
          $splited = split(" ",$this->casefolding($tweet)); 
		  //debug( $splited ); exit; 
          $aspal = $aliaswords;
		  
		  return $this->filterToken($splited,$aspal);
		  
      }
	  
	        
      public function processNumbers($word){
         $str = "";
         for($i=0;$i<10;$i++ ){
            $str = (string)$i;
            if (strpos($word, $str) !== false) { 
  

            switch ($i) {
                case 0:
                    $word =  str_replace($str,"o",$word);
                    break;
                case 1:
                    $word =  str_replace($str,"i",$word);
                    break;
                case 2:
                    $pos = strpos($word,$str);
                    $word = substr($word, 0, $pos).' '.substr($word, 0, $pos );  
                    break;
                case 3:
                    $word =  str_replace($str,"e",$word);
                    break;
                case 4:
                    $word =  str_replace($str,"a",$word);
                    break;
                case 5:
                    $word =  str_replace($str,"s",$word);
                    break;
                case 6:
                    $word =  str_replace($str,"g",$word);
                    break;
                case 7:
                    $word =  str_replace($str,"t",$word);
                    break;
                case 8:
                    $word =  str_replace($str,"b",$word);
                    break;
                case 9:
                    $word =  str_replace($str,"g",$word);
                    break;
            }
            
            }
         }
                   
         

         return trim($word);
      }
  }
?>
