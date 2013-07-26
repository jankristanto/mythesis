<?php
Configure::load('Twitteroauth.twitter');

/**
 * TwitterComponent
 *
 * Provides an entry point into @abraham's PHP twitteroauth Library.
 */
class TwitterComponent extends Component {

  /**
   * Holds an array of valid service "names" and the class that corresponds
   * to each one.
   *
   * @var array
   * @access private
   */
  private $__services = array(
    'OAuth' => 'TwitterOAuth'
  );
  
  /**
   * Constructor merge settings
   * 
   * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
   * @param array $settings Array of configuration settings.
   */
  public function __construct(ComponentCollection $collection, $settings = array()) {
    parent::__construct($collection, $settings);
  }
  
  /**
   * Initialization method. Triggered before the controller's `beforeFilfer`
   * method but after the model instantiation.
   *
   * @param Controller $controller
   * @param array $settings
   * @return null
   * @access public
   */
  public function initialize(Controller $controller) {
    // Handle loading our library firstly...
    App::build(array('Vendor' => array(
      APP.'Plugin'.DS.'Twitteroauth'.DS .'Vendor'.DS)
    ));    
    App::import('Vendor', 'Twitter', array(
      'file' => 'abraham-twitteroauth'.DS.'twitteroauth'.DS.'twitteroauth.php'
    ));
  }
  
  /**
   * PHP magic method for satisfying requests for undefined variables. We
   * will attempt to determine the service that the user is requesting and
   * start it up for them.
   *
   * @var string $variable
   * @return mixed
   * @access public
   */
  public function __get($variable) {
    if (in_array($variable, array_keys($this->__services))) {
      // Store away the requested class for future usage.
      $this->$variable = $this->__createService(
        $this->__services[$variable]
      );
      // Return the class back to the caller
      return $this->$variable;
    }
  }

  /**
   * Instantiates and returns a new instance of the requested `$class` object.
   *
   * @param string $class
   * @return object
   * @access private
   */
  private function __createService($class) {
    return new $class(
      Configure::read('Twitter.consumer_key'),      
      Configure::read('Twitter.consumer_secret'),      
      Configure::read('Twitter.oauth_token'),      
      Configure::read('Twitter.oauth_token_secret')
    );
  }  
}