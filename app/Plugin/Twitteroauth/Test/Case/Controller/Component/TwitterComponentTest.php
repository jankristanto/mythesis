<?php

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Twitteroauth.Controller');
App::uses('TwitterComponent', 'Twitteroauth.Controller/Component');

// A fake controller to test against
class TestTwitterController extends Controller {
}

class TwitterComponentTest extends CakeTestCase {

  public $Twitter = null;
  public $Controller = null;

  public function setUp() {
    parent::setUp();
    // Setup our component and fake test controller
    $Collection = new ComponentCollection();
    $this->Twitter = new TwitterComponent($Collection);
    $this->Controller = new TestTwitterController();
    $this->Twitter->initialize($this->Controller);
  }
  
  public function tearDown() {
    parent::tearDown();
    // Clean up after we're done
    unset($this->Twitter);
    unset($this->Controller);
  }
  
  /**
   * test GET legal/privacy (requires no authentication)
   */
  public function testGetLegalPrivacy() {
    $result = Set::reverse($this->Twitter->OAuth->get(
       'legal/privacy', array()
    ));
    $this->assertTrue(isset($result['privacy']));        
  }
  
  /**
   * test GET account/verify_credentials (requires authentication)
   */
  public function testGetAccountVerifyCredentials() {
    $result = Set::reverse($this->Twitter->OAuth->get(
       'account/verify_credentials', array()
    ));
    $this->assertTrue(isset($result['id']));        
  }  
}