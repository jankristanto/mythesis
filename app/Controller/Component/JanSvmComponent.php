<?php
	App::import('Vendor', 'PHPSVM', array('file' => 'svm.php'));
	class JanSvmComponent extends Component{
		public $phpsvm;
		public function initialize(Controller $controller){
			$this->phpsvm = new PHPSVM();
        }
    
		public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
            $this->Controller = $collection->getController();
            parent::__construct($collection, $settings);
		}
		
		public function train($filetraining){
			
			$this->phpsvm->train($filetraining, 'files/model.svm');
		}
		
		public function test($filetesting){
			return $this->phpsvm->test($filetesting, 'files/model.svm', 'files/output.dat');
		}
		
	}
?>
