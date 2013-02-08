<?php
//TextParse Class 0.2 By ming0070913
Class TextParse{
	public $text, $lenght, $char, $letter, $number, $space, $word, $r_word,
			$sen, $r_sen, $para, $r_para, $beautified;
	
	public function __construct($text){
		$this->text = $text;
	}
	
	public function getLenght(){
		if($this->lenght==NULL) $this->lenght = strlen($this->text);
		return $this->lenght;
	}
	
	public function getCharacter(){
		if($this->char==NULL) $this->char = strlen(strtr($this->text, array("\n"=>'', "\r"=>'')));
		return $this->char;
	}
	
	public function getLetter(){
		$this->checkLetterNumber();
		return $this->letter;
	}
	
	public function getNumber(){
		$this->checkLetterNumber();
		return $this->number;
	}
	
	protected function checkLetterNumber(){
		if($this->letter==NULL || $this->number==NULL){
			$this->letter = $this->number = 0;
			$l_text = strtolower($this->text);
			for($i=0;$i<$this->lenght;$i++){
				if(strpos("abcdefghijklmnopqrstuvwxyz", $l_text[$i])!=false) $this->letter++;
				elseif(strpos("0123456789", $l_text[$i])!=false) $this->number++;
			}
		}
		return;
	}
	
	public function getSpace(){
		if(!$this->space) $this->space = substr_count($this->text, " ")+substr_count($this->text, "\t");
		return $this->space;
	}
	
	public function getSymbol(){
		return $this->getCharacter() - $this->getLetter() - $this->getNumber() - $this->getSpace();
	}
	
	public function getWord($parse=false){
		if($this->word==NULL && $this->r_word==NULL){
			@preg_match_all("/[A-Za-z\-'\\\"]+/", $this->text, $m);
			$this->word = count($m[0]);	
			$this->r_word = $m[0];
		}
		return $parse?$this->r_word:$this->word;
	}
	
	public function getSentence($parse=false){
		if($this->sen==NULL && $this->r_sen==NULL){
			@preg_match_all("/[^:|;|\!|\.]+(:|;|\!|\.| )+/", $this->text, $m);
			$this->sen = count($m[0]);
			foreach($m[0] as $s)
				$this->r_sen[] = strtr(trim($s), array("\n"=>'', "\r"=>''));
		}
		return $parse?$this->r_sen:$this->sen;
	}
	
	public function getParagraph($parse=false){
		if($this->para==NULL && $this->r_para==NULL){
			@preg_match_all("/[^\n]+?\n/s", strtr($this->text, array("\r"=>''))."\n", $m);
			$this->para = count($m[0]);
			foreach($m[0] as $p)
				$this->r_para[] = trim($p);
		}
		return $parse?$this->r_para:$this->para;
	}
	
	public function beautify($wordwrap=false){
		if($this->beautified==NULL){
			$this->beautified = @preg_replace(
				array(
					"/ {1,}/",
					"/\. {1,}\./",
					"/\. *(?!\.)/",
					"/(,|:|;|\!|\)) */",
					"/(,|:|;|\!|\)|\.) *\r?\n/",
					"/(\r?\n){3,}/"
				), array(
					" ",
					".",
					". ",
					"$1 ",
					"$1\r\n",
					"\r\n\r\n"
				), $this->text);
		}
		return $wordwrap?wordwrap($this->beautified, $wordwrap):$this->beautified;
	}
}
?>