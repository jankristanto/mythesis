<?php

class MyTwitterComponent extends Component{
    public $settings = array(
        'lang' => 'in',
        'page' => 1,
        'rpp' => 100
        
    );
    
    public function initialize(Controller $controller){
        // saving the controller reference for later use
        $this->realNamePattern = '/\((.*?)\)/';
    }
    
    public function __construct(ComponentCollection $collection, $settings = array()){
        $settings = array_merge($this->settings, (array)$settings);
        $this->Controller = $collection->getController();
        parent::__construct($collection, $settings);
    }
    
    public function getTweets($q){
        App::uses('Xml', 'Utility');
        $output = array();
        $this->searchURL = 
        'http://search.twitter.com/search.atom?page='.$this->settings['page'].
		'&lang='.$this->settings['lang'].'&rpp='.$this->settings['rpp'].'&q=';
        $ch= curl_init($this->searchURL . urlencode($q));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        $response = curl_exec($ch);
        $xmlResult = Xml::toArray(Xml::build($response));
    
        curl_close($ch);
        return $xmlResult;
    }
    
    public function getAllTweets($q,$limit=1){
        $results[$this->settings['page']] = $this->getTweets($q);
        
        while (array_key_exists('feed', $results[$this->settings['page']]) && $this->checkNext($results[$this->settings['page']]['feed']['link']) && $this->settings['page'] <=$limit){
            $this->settings['page'] +=1;
            $results[$this->settings['page']] = $this->getTweets($q); 		
        }
        return $results;
    }
    
    public function checkNext($links){
        foreach($links as $link ){
            if($link['@rel'] == 'next'){
                return true;
            }
        }
        
        return false;
    }

    
    
}

?>
