<?php


App::uses('AppController', 'Controller');


class PagesController extends AppController {

	public $name = 'Pages';


	public $helpers = array('Html', 'Session');

	public $uses = array('Tweet','FormalWord','Query','Comparison');
    
    public $components = array(
        'MyTwitter' => array(
            'lang' => 'in'
        ),
        'Preprocessing', 
        'JanPosTagging',
        'JanGoogleTranslate',
        'SentimentAnalysisLexiconBased'
    );
	
	public function singleLinguisticAnalisys(){
		$kalimat = 'sedihnya hati ini';
		$hasil = $this->JanPosTagging->singlePostTag($this->Preprocessing->doIt($kalimat));
		$hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
		$hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
		$hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
        debug($hasil); exit;      
		exit;
		
	}
	
	function generateTestingData(){
	
		$this->Tweet->CleanTweet->recursive = -1;
		$data = $this->Tweet->CleanTweet->find('all'); 
		$hasil = $this->getIndex($data);
		//debug($hasil); exit;
		$kalimat = 'obama pasti kalah';
		$status = 'negatif';
		$terms = explode(' ', $kalimat);
		//debug($hasil['result']['menang']); exit;
		$x =0;
		
		if($status == 'positif'){
			echo '+1 '; 
			foreach($terms as $i => $term){
				if(isset($hasil['result'][$term]) && ($hasil['result'][$term][$status] >0)){
					echo ($x+1).':'.$hasil['result'][$term]['positif'].' ';
		
				}
				$x++;
			}
			echo "<br/>";
		}else{
			if($status == 'negatif'){
				echo '-1 '; 
				foreach($terms as $i => $term){
					
					if(isset($hasil['result'][$term]) && ($hasil['result'][$term][$status] >0)){
						echo ($x+1).':'.$hasil['result'][$term]['negatif'].' ';
				
					}
					$x++;
					
				}
				echo "<br/>";
			}
		}			
		exit;
	}
	
	function getIndex($collection) {
        $dictionary = array();
        $docCount = array();
		$result = array();
		
			
        foreach($collection as $docID => $doc) {
                $terms = explode(' ', $doc['CleanTweet']['content']); // dapat array kata
                $docCount[$docID] = count($terms); // jumlah kata pada kalimat ke-i
				$status = $doc['CleanTweet']['sentiment'];
				
                foreach($terms as $term) {
                        if(!isset($dictionary[$term])) { // jika menemukan kata baru
								// masukan dalam $dictionary
                                $dictionary[$term] = array('netral' => 0,'positif' => 0,'negatif' => 0,'df' => 0, 'postings' => array());
                        }
                        if(!isset($dictionary[$term]['postings'][$docID])) {
                                $dictionary[$term]['df']++;
                                //$dictionary[$term]['postings'][$docID] = array('tf' => 0);
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
						
                        //$dictionary[$term]['postings'][$docID]['tf']++;
						$result[$term]['term'] = $term;
						$result[$term]['positif'] = $dictionary[$term]['positif'];
						$result[$term]['negatif'] = $dictionary[$term]['negatif'];
						
                }
        }
        return array('docCount' => $docCount, 'dictionary' => $dictionary,'result' => $result);
	}
	
	function generateTrain($data,$fr){
		
		foreach($data as $index => $sample){
			$terms = explode(' ', $sample['CleanTweet']['content']);
			//debug($sample); exit;
			$x=0;
			if($sample['CleanTweet']['sentiment'] == 'positif'){
				echo '+1 '; 
				foreach($terms as $i => $term){
					if($term != ''){
					echo ($x+1).':'.$fr[$term]['positif'].' ';
					
					}
					$x++;
					
				}
				echo "<br/>";
			}else{
				if($sample['CleanTweet']['sentiment'] == 'negatif'){
					echo '-1 '; 
					foreach($terms as $i => $term){
						if($term != ''){
							echo ($x+1).':'.$fr[$term]['negatif'].' ';
							
						}
						$x++;
					}
					echo "<br/>";
				}
			}			
		}
		exit;
	}
    
    function coba(){
        //debug($this->FormalWord->extract('keterlaluan')); exit;
		$this->Tweet->CleanTweet->recursive = -1;
		
		$data = $this->Tweet->CleanTweet->find('all'); 
		//debug($data); exit;
		$hasil = $this->getIndex($data);
		debug($hasil['dictionary']); exit;
		$this->generateTrain($data,$hasil['result']); 
        
    }
    
    function test(){
        $this->FormalWord->recursive = -1;
        $formals = $this->FormalWord->find('all',
        array('fields' => array('id','text'),'limit' => 1000,'page' =>40));
        
        //$formals = $this->FormalWord->find('all',array('fields' => array('id','text')));
        foreach($formals as $index => $formal){
            $formals[$index]['FormalWord']['en'] = $this->JanGoogleTranslate->translate($formal['FormalWord']['text'],'id_to_en');
        }
        
       $this->FormalWord->saveAll($formals); exit;
    }
	
	function coba2(){
		//$this->Query->recursive = -1; 
		/*$data = $this->Query->Repository->find('all',
				array(
					'conditions' => array('id_query' => 9),
					'limit' => 100
				)
			);
		$comp = array();
		foreach($data as $index => $repo){
			$comp[$index]['Comparison']['content'] = $repo['Repository']['tweet'];
			$comp[$index]['Comparison']['published'] = $repo['Repository']['tanggal'];
			$comp[$index]['Comparison']['author'] = $repo['Repository']['penulis'];
			$comp[$index]['Comparison']['other'] = -1;
		}
		
		echo $this->Comparison->saveAll($comp);*/ 
		
		$dataTweet = $this->Comparison->find('all');
		//$dataTweet = $this->Tweet->find('all');
        //debug($dataTweet); exit;
        $cleanTweets = array();
        foreach($dataTweet as $index => $tw){
            $cleanTweets[$index]['CleanTweet']['id'] = $tw['Comparison']['id'];
			$cleanTweets[$index]['CleanTweet']['content'] = $this->Preprocessing->doIt($tw['Comparison']['content']);
        }
               
        //$this->Tweet->CleanTweet->saveAll($cleanTweets);
        
		
		$dataBersih = $cleanTweets;
		//$dataBersih = $this->Tweet->CleanTweet->find('all');
        //debug($dataBersih); exit;
        $hasil = array();
        
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
            $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
            $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
            $dataBersih[$index]['CleanTweet']['conclusion'] = $hasil['conclusion'];
			//$this->Tweet->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id']; 
            //$this->Tweet->CleanTweet->saveField('sentiment',$hasil['conclusion']);
        }
        debug($dataBersih);
		exit;
	}


	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
    
    public function getTweet($term){
        //debug($this->MyTwitter->getAllTweets('telkomsel')); exit;    
        $d = $this->MyTwitter->getAllTweets($term);
        $entry = array();
        $i = 0;
        $vowels = array("T", "Z");
        foreach($d[1]['feed']['entry'] as $ent){
            $da = str_replace($vowels, " ", $ent['published']);
            $entry[$i]['published'] = $da;
            $entry[$i]['content'] = $ent['title'];
            $entry[$i]['link_tweet'] = $ent['link'][0]['@href'];
            $entry[$i]['avatar_image_link'] = $ent['link'][1]['@href'];
            $entry[$i]['content_html'] = $ent['content']['@'];
            $entry[$i]['author_name'] = $ent['author']['name'];
            $entry[$i]['author_link'] = $ent['author']['uri'];
            $entry[$i]['source'] = $ent['twitter:source'];
            
            $i++;
        }
        
        //debug($entry); exit;
        if($this->Tweet->saveAll($entry)){
			echo 'Berhasil. ditemukan '.count($entry).' dengan term '.$term;
		} 
		
		exit;
        
    }
    
    function preprocessing($page){
        $dataTweet = $this->Tweet->find('all',array('limit' => 30,'page'=> $page));
		//$dataTweet = $this->Tweet->find('all');
        //debug($dataTweet); exit;
        $cleanTweets = array();
        foreach($dataTweet as $index => $tw){
            $cleanTweets[$index]['CleanTweet']['content'] = $this->Preprocessing->doIt($tw['Tweet']['content']);
            $cleanTweets[$index]['CleanTweet']['tweet_id'] = $tw['Tweet']['id'];
        }
               
        $this->Tweet->CleanTweet->saveAll($cleanTweets);
        debug($cleanTweets);
        exit;
        
    }
    
    public function check($id){
        $this->Tweet->CleanTweet->recursive = -1;
        $dataBersih = $this->Tweet->CleanTweet->findById($id);    
        $hasil = $this->JanPosTagging->posTagDic($dataBersih['CleanTweet']['content'],$dataBersih['CleanTweet']['id']);
        
        $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
        //debug($hasil);
        $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
        $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
        debug($hasil); exit;      
    }
    
    function process($page){
        
        $this->Tweet->CleanTweet->recursive = -1;
        $dataBersih = $this->Tweet->CleanTweet->find('all',array('limit' => 20,'page'=> $page));
		//$dataBersih = $this->Tweet->CleanTweet->find('all');
        //debug($dataBersih); exit;
        $hasil = array();
        
        foreach($dataBersih as $index => $t){
            $hasil = $this->JanPosTagging->posTagDic($dataBersih[$index]['CleanTweet']['content'],$dataBersih[$index]['CleanTweet']['id']);
            $hasil['frase'] = $this->SentimentAnalysisLexiconBased->preliminaryAnalysis($hasil);
            $hasil = $this->SentimentAnalysisLexiconBased->checkNegation($hasil);
            $hasil['conclusion'] = $this->SentimentAnalysisLexiconBased->conclusion($hasil['frase']);
            $this->Tweet->CleanTweet->id = $dataBersih[$index]['CleanTweet']['id']; 
            $this->Tweet->CleanTweet->saveField('sentiment',$hasil['conclusion']);
        }
        
        
        echo 'end';
        exit;
        
    }
}

