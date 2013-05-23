<?php
	class SpellingCorrectionComponent extends Component{

		public function __construct(ComponentCollection $collection, $settings = array()){
			//$settings = array_merge($this->settings, (array)$settings);
			$this->Controller = $collection->getController();
			parent::__construct($collection, $settings);
		}
		
		/*
		function to generate dictinoary
		I prefer to input dictionary in function correct
		*/
		
		public function train($file = 'dic.txt') {
			$contents = file_get_contents($file);
			// get all strings of word letters
			preg_match_all('/\w+/', $contents, $matches);
			unset($contents);
			$dictionary = array();
			foreach($matches[0] as $word) {
					$word = strtolower($word);
					if(!isset($dictionary[$word])) {
							$dictionary[$word] = 0;
					}
					$dictionary[$word] += 1;
			}
			unset($matches);
			return $dictionary;
		}

		public function correct($word, $dictionary) {
			if(strlen($word) <255){
				$word = strtolower($word);
				if(isset($dictionary[$word])) {
						return $word;
				}
				$edits1 = $edits2 = array();
				foreach($dictionary as $dictWord => $count) {
						$dist = levenshtein($word, $dictWord);
						if($dist == 1) {
								$edits1[$dictWord] = $count;
						} else if($dist == 2) {
								$edits2[$dictWord] = $count;
						}
				}
				if(count($edits1)) {
						arsort($edits1);
						return key($edits1);
				} else if(count($edits2)) {
						arsort($edits2);
						return key($edits2);
				}	
			}else{
				$word = '';
			}
			return $word;
		}
	}
?>
