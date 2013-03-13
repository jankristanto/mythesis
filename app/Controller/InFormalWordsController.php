<?php
class InFormalWordsController extends AppController{
	public $name = 'InFormalWords'; 
	public $components = array('Session');
	public $paginate = array(
		'limit' => 25
	);

	public function index(){
		$data = $this->paginate('InFormalWord');
		$this->set('data', $data);
	}

	public function add(){
		if ($this->request->is('post')) {
			if ($this->InFormalWord->save($this->request->data)) {
				$this->Session->setFlash('A New Word has been saved.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('Unable to add your word.','default', array(), 'flash_error');
			}
		}         
	}
	
	public function l(){
		$kata = $this->InFormalWord->find('list',array(
			'fields' => array('InFormalWord.aspal','FormalWord.text'),
			'recursive' => 1
			
			)
			
		);   
		debug($kata);
	}
}
?>
