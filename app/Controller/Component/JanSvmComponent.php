<?php
	//App::import('Vendor', 'PHPSVM', array('file' => 'svm.php'));
	class JanSvmComponent extends Component{
		//public $phpsvm;
		//public $phpsvm;
		public function initialize(Controller $controller){
			//$this->phpsvm = new PHPSVM();
        }
    
		public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
            $this->Controller = $collection->getController();
            parent::__construct($collection, $settings);
		}
		
		public function train($filetraining,$filemodel){
			//$this->phpsvm->train($filetraining, 'files/model.svm');
			chdir('files'); 
			echo exec('svm-train '.$filetraining.' '.$filemodel);
			//echo getcwd() . "\n";exit;
		}
		
		public function test($filetesting,$filemodel,$fileout){
			//return $this->phpsvm->test($filetesting, 'files/model.svm', 'files/output.dat');
			chdir('files'); 
			echo exec('svm-predict '.$filetesting.' '.$filemodel.' '.$fileout);
		}
		
	}
?>
