<?php
require_once "usernameAndPassword.php";
Class AuthenticationModel{
	private $usernameAndPassword;
	private static $loggedInSession = "loggedInSession";
	private static $sessionSecurity = "session_security";
	private static $browser = "webbläsare";
	public $messageForLoginForm = "";
	public function __construct(){
		$this->usernameAndPassword = new UsernameAndPassword();
	}
	
	public function compareUsernameAndPassword($username, $password){
		if($this->usernameAndPassword->getUsername() == $username 
		&& $this->usernameAndPassword->getPassword() == $password){
			$this->setLoggedInSession();
			return true;	
		}
		$this->messageForLoginForm = "Fel användarnamn eller lösenord";
		return false;
	}
	
	public function checkIfLoggedIn(){
		if(isset($_SESSION[self::$loggedInSession])){
			if($this->checkSession()){
				return TRUE;
			}
			return FALSE;
		}
		return FALSE;
	}
	
	private function setLoggedInSession(){
		$_SESSION[self::$loggedInSession] = TRUE;
		$_SESSION[self::$sessionSecurity] = array();
		$_SESSION[self::$sessionSecurity][self::$browser] = $this->getUserAgent();	
	}

	private function checkSession(){
		if($_SESSION[self::$sessionSecurity][self::$browser] === $this->getUserAgent()){
			return TRUE;
		}
		return FALSE;
	}
	public function logOut(){
		unset($_SESSION[self::$loggedInSession]);
		session_destroy();
		header("Location: index.php");
		die();
	}
	
	// Magic happens in this function to find out the users browser
    //http://stackoverflow.com/questions/9693574/user-agent-extract-os-and-browser-from-string-php
	private static function getUserAgent(){
    	static $agent = null;
	    if ( empty($agent) ) {
	        $agent = $_SERVER['HTTP_USER_AGENT'];
	        if ( stripos($agent, 'Firefox') !== false ) {
	            $agent = 'firefox';
	        } elseif ( stripos($agent, 'MSIE') !== false ) {
	            $agent = 'ie';
	        } elseif ( stripos($agent, 'iPad') !== false ) {
	            $agent = 'ipad';
	        } elseif ( stripos($agent, 'Android') !== false ) {
	            $agent = 'android';
	        } elseif ( stripos($agent, 'Chrome') !== false ) {
	            $agent = 'chrome';
	        } elseif ( stripos($agent, 'Safari') !== false ) {
	            $agent = 'safari';
	        } elseif ( stripos($agent, 'AIR') !== false ) {
	            $agent = 'air';
	        } elseif ( stripos($agent, 'Fluid') !== false ) {
	            $agent = 'fluid';
	        }
	    }
	    return $agent;
	}
}
