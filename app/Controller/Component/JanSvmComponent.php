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
			chdir('files'); 
			exec('svm-train '.$filetraining.' '.$filemodel);
		}
		
		public function test($filetesting,$filemodel,$fileout){
			chdir('files'); 
			exec('svm-predict '.$filetesting.' '.$filemodel.' '.$fileout);
		}
		public function test2($filetesting,$filemodel,$fileout){
			chdir('files'); 
			exec('svm-predict '.$filetesting.' '.$filemodel.' '.$fileout);
		}
		
	}
?>
