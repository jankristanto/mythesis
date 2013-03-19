<?php

App::uses('Controller', 'Controller');

/**
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	//public $components = array('DebugKit.Toolbar');
	
    public $helpers = array('Html', 'Form', 'Session','JanProject',
        'BootstrapForm', 'BootstrapPaginator'
    );
    public $dictionary; 
	
	public function beforeFilter(){
		$this->dictionary = $this->generateDictionary(WWW_ROOT.'files/dic.txt');
	}
    
	public function generateDictionary($path){
		$contents = file_get_contents($path);
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
}
