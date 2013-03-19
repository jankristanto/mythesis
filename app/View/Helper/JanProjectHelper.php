<?php
App::uses('AppHelper', 'View/Helper');

class JanProjectHelper extends AppHelper {
    public $helpers = array('Html','Form','Session','Js');

    public function js(){
        $output = $this->Html->script('JanProject');
        $project = array();
        $project['basePath'] = Router::url('/',true); //fix bug request ajax aborted
        $output .= $this->Html->scriptBlock('$.extend(Project, ' . $this->Js->object($project) . ');');
        echo $output;
    }
	public function loadTinyMCE(){
        return $this->Html->script('tinymce/jscripts/tiny_mce/jquery.tinymce');
    }
}