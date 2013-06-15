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
	
	public function getTfidfTesting($id,$doctesting,$testingindex, $trainingindex,$indexfiturbaru){
		$docCount = count($trainingindex['docCount']);
		$terms = explode(' ', $doctesting['content']);
		$hasil = array(); 
		//pr($doctesting);
		//pr($testingindex);
		if($doctesting['sentiment'] != 'netral' ){
            $result = "0";
			foreach($terms as $i => $term){
				if(isset($trainingindex['dictionary'][$term])){
					$urutan = $trainingindex['dictionary'][$term]['index'];
					$entry = $testingindex['dictionary'][$term];
					$score = round($entry['postings'][$id]['tf'] 
					* log(($docCount+1) / ($trainingindex['dictionary'][$term]['df']+1), 2), 5); 
                    $hasil[$urutan] = $score; 
				}	
			}
            ksort($hasil);
            foreach($hasil as $index => $bobot){
                $result = $result." {$index}".":"."{$bobot}";
            }
			$result .= "\n";
			
			if($this->filetesting->exists()){
				$this->filetesting->append($result);
			}			
			
			return $indexfiturbaru;
		}
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
						$dictionary[$term] = array( 'netral' => 0,'positif' => 0,
						'negatif' => 0,'df' => 0, 'postings' => array());
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
					$score = round($entry['postings'][$idDoc]['tf'] 
					* log(($docCount+1) / ($entry['df']+1), 2), 5); 
                    $hasil[$urutan] = $score; 
				}	
			}
            ksort($hasil);
            foreach($hasil as $index => $bobot){
                $result = $result." {$index}".":"."{$bobot}";
                
            }
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
        $docpos = $this->CleanRepository->find('all', array("conditions" => "CleanRepository.sentiment = 'positif'", "limit" => 12500));
		$docneg = $this->CleanRepository->find('all', array("conditions" => "CleanRepository.sentiment = 'negatif'", "limit" => 12500));
        $pos = Set::classicExtract($docpos, '{n}.CleanRepository');
		$neg = Set::classicExtract($docneg, '{n}.CleanRepository');
		$data = Set::classicExtract($d, '{n}.CleanTweet');
		
		$allDoc = array_merge($pos,$neg);
		
		$indextraining = $this->getIndex($allDoc);
		$indextesting = $this->getIndex($data);
		
		//pr($indextesting); 
		$indexfiturbaru = count($indextraining['dictionary']) + 1;
		foreach($data as $id => $r){
			$indexfiturbaru = $this->getTfidfTesting($id,$r,$indextesting,$indextraining,$indexfiturbaru); 
		}
	}
	
	public function buildTrainingData(){
		file_put_contents($this->filetraining->pwd(), "");
        $this->CleanRepository->recursive = -1;
		$positif = $this->CleanRepository->find('all', array(
			'conditions' => array('CleanRepository.sentiment' => 'positif'), 
			'limit' => 12500
			)
		);
		$negatif = $this->CleanRepository->find('all', array(
			'conditions' => array('CleanRepository.sentiment' => 'negatif'), 
			'limit' => 10500
			)
		);
		$all = array_merge($positif, $negatif);
	    $allDoc = Set::classicExtract($all, '{n}.CleanRepository');
        $index = $this->getIndex($allDoc);
		foreach($allDoc as $id => $d){
			$this->getTfidf($d,$id,$allDoc,$index,'train'); 
		}	
	}
	
	public function reBuildTrainingData(){
		//file_put_contents($this->filetraining->pwd(), "");
		$this->CleanRepository->recursive = -1;
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
	    $allDoc = Set::classicExtract($all, '{n}.CleanRepository');
		
		$new = $this->CleanTweet->getAll();
		$newDoc = Set::classicExtract($new, '{n}.CleanTweet');
		$allnew = array_merge($newDoc,$allDoc);
		//pr($newDoc); exit;
		$jumlahBaru = count($newDoc);
        $index = $this->getIndex($allnew);
		foreach($allnew as $id => $d){
			if($id == $jumlahBaru){
				break;
			}
			$this->getTfidf($d,$id,$allnew,$index,'train'); 
		}	
	}
}

?>
