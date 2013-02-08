<?php
  class JanGoogleTranslateComponent extends Component{
      
      public function initialize(Controller $controller){
           
      }
    
      public function __construct(ComponentCollection $collection, $settings = array()){
            //$settings = array_merge($this->settings, (array)$settings);
            $this->Controller = $collection->getController();
            parent::__construct($collection, $settings);
      }
      
      
        function curl($url,$params = array(),$is_coockie_set = false){

            if(!$is_coockie_set){
            /* STEP 1. let’s create a cookie file */
            $ckfile = tempnam ("/tmp", "CURLCOOKIE");

            /* STEP 2. visit the homepage to set the cookie properly */
            $ch = curl_init ($url);
            curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec ($ch);
            }

            $str = ''; $str_arr= array();
            foreach($params as $key => $value){
            $str_arr[] = urlencode($key)."=".urlencode($value);
            }
            if(!empty($str_arr))
            $str = '?'.implode('&',$str_arr);

            /* STEP 3. visit cookiepage.php */

            $Url = $url.$str;

            $ch = curl_init ($Url);
            curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);

            $output = curl_exec ($ch);
            return $output;
        }

        public function Translate($word,$conversion = 'en_to_id'){
            $word = urlencode($word);
            $arr_langs = explode('_to_', $conversion);
            $url = "http://translate.google.com/translate_a/t?client=t&text=$word&hl=".$arr_langs[1]."&sl=".$arr_langs[0]."&tl=".$arr_langs[1]."&ie=UTF-8&oe=UTF-8&multires=1&otf=1&pc=1&trs=1&ssel=3&tsel=6&sc=1";

            $name_en = $this->curl($url);

            $name_en = explode('"',$name_en);
            return  $name_en[1];
        }
      
  }
?>
