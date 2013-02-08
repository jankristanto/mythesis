<?php
App::uses('Folder', 'Utility');
App::uses('File', 'Utility');
class WeightComponent extends Component{
	public $CleanTweet;
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
		$this->dir = new Folder(WWW_ROOT.'files', true, 0755);
		$this->filetraining = new File(WWW_ROOT.'files/train.dat', true, 0644);
		$this->filetesting = new File(WWW_ROOT.'files/test.dat', true, 0644);
        parent::__construct($collection, $settings);
    }

	public function getIndex($collection) {
        $dictionary = array();
        $docCount = array();
		$result = array();
		$i =1;
			
        foreach($collection as $doc) {
				$docID = $doc['CleanTweet']['id'];
                $terms = explode(' ', $doc['CleanTweet']['content']); // dapat array kata
                $docCount[$docID] = count($terms); // jumlah kata pada kalimat ke-i
				$status = $doc['CleanTweet']['sentiment'];
				
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
						//$result[$term]['term'] = $term;
						//$result[$term]['positif'] = $dictionary[$term]['positif'];
						//$result[$term]['negatif'] = $dictionary[$term]['negatif'];
						
                }
        }
		unset($dictionary['']);
		return array('docCount' => $docCount, 'dictionary' => $dictionary);
        
	}
	
	function getTfidf($doc,$allDoc,$index,$mode) {
        $index = $index;
        $docCount = count($index['docCount']);
        
		$terms = explode(' ', $doc['CleanTweet']['content']);
		$idDoc = $doc['CleanTweet']['id'];
		
		$status = array('netral'=> '0','positif' => '1' ,'negatif' => '-1');
		$hasil = array(); 
		if($doc['CleanTweet']['sentiment'] != 'netral' ){
			if($mode == 'test'){
                $result = "0";
            }else{
                $result =  "{$status[$doc['CleanTweet']['sentiment']]}";    
            }
            
			
			foreach($terms as $i => $term){
				if(isset($index['dictionary'][$term])){
					$urutan = $index['dictionary'][$term]['index'];
					$entry = $index['dictionary'][$term];
					$score = round($entry['postings'][$idDoc]['tf'] * log($docCount / $entry['df'], 2), 5); 
                    
					/*$result = $result."{$urutan}".":"."{$score}"." ";*/
                    $hasil[$urutan] = $score/100; 
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
	
	public function buildTestingData($data,$allDoc){
		file_put_contents($this->filetesting->pwd(), "");
		$index = $this->getIndex($allDoc);
		
		//debug($index); exit;
		foreach($data as $d){
			$this->getTfidf($d,$allDoc,$index,'test'); 
		}	
	}
	
	public function buildTrainingData(){
		/*$count['netral'] = $this->CleanTweet->find('count',array('conditions' => array('sentiment' => 'netral')));
		$count['positif'] = $this->CleanTweet->find('count',array('conditions' => array('sentiment' => 'positif')));
		$count['negatif'] = $this->CleanTweet->find('count',array('conditions' => array('sentiment' => 'positif')));
		
		$min = min($count); 
		$netral = $this->CleanTweet->find('all',array('conditions' => array('sentiment' => 'netral') ,'limit'=> $min));
		$positif = $this->CleanTweet->find('all',array('conditions' => array('sentiment' => 'positif') ,'limit'=> $min));
		$negatif = $this->CleanTweet->find('all',array('conditions' => array('sentiment' => 'negatif') ,'limit'=> $min));
		$result = array_merge($netral, $positif);
		$allDoc = array_merge($result,$negatif);*/
		file_put_contents($this->filetraining->pwd(), "");
        $this->CleanTweet->recursive = -1;
		$allDoc = $this->CleanTweet->find('all', array("conditions" => "CleanTweet.sentiment = 'positif' OR CleanTweet.sentiment = 'negatif'"));
		
        $index = $this->getIndex($allDoc);
		
		//debug($index); exit;
		foreach($allDoc as $d){
			$this->getTfidf($d,$allDoc,$index,'train'); 
		}	
	}
}

?>
