<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class WeightComponent extends Component{
	public $CleanTweet;
    public $CleanRepository;
	public $dir;
	public $filetraining;
	public $filetesting;
    public $settings = array(
       
    );
    
    public function initialize(Controller $controller){
        // saving the controller reference for later use
        $this->realNamePattern = '/\((.*?)\)/';
    }
    
    public function __construct(ComponentCollection $collection, $settings = array()){
        $settings = array_merge($this->settings, (array)$settings);
        $this->Controller = $collection->getController();
		$this->CleanTweet = ClassRegistry::init('CleanTweet');
        $this->CleanRepository = ClassRegistry::init('CleanRepository');
		$this->dir = new Folder(WWW_ROOT.'files', true, 0755);
		$this->filetraining = new File(WWW_ROOT.'files/jan.train', true, 0644);
		$this->filetesting = new File(WWW_ROOT.'files/jan.test', true, 0644);
        parent::__construct($collection, $settings);
    }

	public function getIndex($collection) {
        $dictionary = array();
        $docCount = array();
		$result = array();
		$i =1;
			
        foreach($collection as $id => $doc) {
			$docID = $id;
			$terms = explode(' ', $doc['content']); // dapat array kata
			$docCount[$docID] = count($terms); // jumlah kata pada kalimat ke-i
			$status = $doc['sentiment'];
			
			foreach($terms as $term) {
					if(!isset($dictionary[$term])) { // jika menemukan kata baru
							// masukan dalam $dictionary
							$dictionary[$term] = array( 'netral' => 0,'positif' => 0,'negatif' => 0,'df' => 0, 'postings' => array());
							$dictionary[$term]['index'] = $i; 
							$i++;
							
					}
					if(!isset($dictionary[$term]['postings'][$docID])) {
							$dictionary[$term]['df']++;
							$dictionary[$term]['postings'][$docID] = array('tf' => 0);
							if($status == 'positif'){
								$dictionary[$term]['positif']++;
							}else{
								if($status == 'negatif'){
									$dictionary[$term]['negatif']++;
								}else{
									if($status == 'netral'){
										$dictionary[$term]['netral']++;
									}
								}
							}
					}
					$dictionary[$term]['postings'][$docID]['tf']++;
			}
        }
		unset($dictionary['']);
		return array('docCount' => $docCount, 'dictionary' => $dictionary);
	}
	
	function getTfidf($doc,$id,$allDoc,$index,$mode) {
        $docCount = count($index['docCount']);
		$terms = explode(' ', $doc['content']);
		
		$idDoc = $id;
		$status = array('netral'=> '0','positif' => '1' ,'negatif' => '-1');
		$hasil = array(); 
		if($doc['sentiment'] != 'netral' ){
			if($mode == 'test'){
                $result = "0";
            }else{
                $result =  "{$status[$doc['sentiment']]}";    
            }
			
			foreach($terms as $i => $term){
				if(isset($index['dictionary'][$term])){
					$urutan = $index['dictionary'][$term]['index'];
					$entry = $index['dictionary'][$term];
					$score = round($entry['postings'][$idDoc]['tf'] * log($docCount / $entry['df'], 2), 5); 
                    
					/*$result = $result."{$urutan}".":"."{$score}"." ";*/
                    $hasil[$urutan] = $score/100; 
					//$hasil[$urutan] = $score; 
				}	
			}
            ksort($hasil);
            foreach($hasil as $index => $bobot){
                $result = $result." {$index}".":"."{$bobot}";
                
            }
			//$result .= "\n#".$doc['CleanTweet']['id'];
			$result .= "\n";
			if($mode == 'test'){
				if($this->filetesting->exists()){
					$this->filetesting->append($result);
				}
			}else{
				if($this->filetraining->exists()){
					$this->filetraining->append($result);
				}
			}
		}
	}
	
	public function buildTestingData($d){
		file_put_contents($this->filetesting->pwd(), "");
		$this->CleanRepository->recursive = -1;
        $all = $this->CleanRepository->find('all', array("conditions" => "CleanRepository.sentiment = 'positif' OR CleanRepository.sentiment = 'negatif'", "limit" => 500));
        $allDoc = Set::classicExtract($all, '{n}.CleanRepository');
		$data = Set::classicExtract($d, '{n}.CleanTweet');
		//$res = Set::merge($allDoc,$data);
		$jumlahTest = count($data);
		//debug($data); debug($allDoc); exit; 
		$res = array_merge($data, $allDoc);
		$index = $this->getIndex($res);
		foreach($res as $id => $r){
			if($id == $jumlahTest){
				break;
			}
			$this->getTfidf($r,$id,$res,$index,'test'); 
		}
	}
	
	public function buildTrainingData(){
		file_put_contents($this->filetraining->pwd(), "");
        $this->CleanRepository->recursive = -1;
		/*$all = $this->CleanRepository->find('all', array(
			"conditions" => "CleanRepository.sentiment = 'positif' 
			OR CleanRepository.sentiment = 'negatif'", "limit" => 500)
		);*/
		$positif = $this->CleanRepository->find('all', array(
			'conditions' => array('CleanRepository.sentiment' => 'positif'), 
			'limit' => 12500
			)
		);
		$negatif = $this->CleanRepository->find('all', array(
			'conditions' => array('CleanRepository.sentiment' => 'negatif'), 
			'limit' => 12500
			)
		);
		$all = array_merge($positif, $negatif);
		//debug(count($all)); exit; 
	    $allDoc = Set::classicExtract($all, '{n}.CleanRepository');
        $index = $this->getIndex($allDoc);
		
		foreach($allDoc as $id => $d){
			$this->getTfidf($d,$id,$allDoc,$index,'train'); 
		}	
	}
}

?>
