<?php

class TaurusFacebook extends Taurus {
	public $username;
	
	function __construct(){
		$user = Taurus::fb->api('/me');
		$this->username = $api['username'];
	}

}