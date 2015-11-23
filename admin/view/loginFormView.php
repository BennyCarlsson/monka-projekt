<?php

Class LoginFormView{
	private static $usernameForm = 'usernameForm';
	private static $passwordForm = 'passwordForm';
	private static $loginButton = 'loginButton';
	
	public function checkLoginButton(){
		if(isset($_POST[self::$loginButton])){
			return true;
		}
		return false;
	}
	public function getUsername(){
		return $_POST[self::$usernameForm];
	}
	public function getPassword(){
		return $_POST[self::$passwordForm];
	}
	public function getLoginFormHTML($message){
		$HTML = "<form id='loginForm' method='post' role='form'>
					Användarnamn:
					<input type='text' name='".self::$usernameForm."' id='usernameLoginForm'>
					Password:
					<input type='password' name='".self::$passwordForm."' id='passwordLoginForm'>
					<input type='submit' value='Logga In' name='".self::$loginButton."' id='loginButton'>
				</form>";
		$HTML .= $message;
		return $HTML;
	}
}
