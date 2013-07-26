# Twitteroauth Plugin for CakePHP #

Version 1.0

The Twitteroauth plugin for CakePHP provides a (very) thin veil for CakePHP 2.x applications over [Abraham Williams' twitteroauth](https://github.com/abraham/twitteroauth) for PHP.

## Usage ##

To use the Twitteroauth plugin for requests requiring authentication you must populate the following four lines in your `/app/Plugin/Twitteroauth/Config/twitter.php` file.

    'consumer_key' => 'YOUR_TWITTER_CONSUMER_KEY',
    'consumer_secret' => 'YOUR_TWITTER_CONSUMER_SECRET',
    'oauth_token' => 'YOUR_TWITTER_OAUTH_TOKEN_SECRET',
    'oauth_token_secret' => 'YOUR_TWITTER_OAUTH_TOKEN'

Don't forget to replace the placeholder text with your actual keys!

Keys can be obtained for free from the [developer Twitter website](https://dev.twitter.com).

Controllers that will be using twitteroauth require the TwitterComponent to be included.

    public $components = array('Twitteroauth.Twitter');

In the controller simply call the twitteroauth method now available in the $this->Twitter->OAuth class.

    $result = Set::reverse($this->Twitter->OAuth->get(
       'legal/privacy', array()
    ));

To check the result simply use Set::reverse to convert the object into an array.

For twitteroauth documentation and methods, check https://github.com/abraham/twitteroauth/wiki/documentation

## Requirements ##

* PHP version: PHP 5.2+
* CakePHP version: Cakephp 2.0+