<?php
/*
    TDLive.org Taurus - all your social networking in one place
    Copyright (C) 2013-2015 TDLive.org, et al.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

require('lib/facebook/facebook.php');
require('lib/phpass/PasswordHash.php');

class Taurus {

	/* Facebook */
	private $fb;
	private $fb_config;
	private $fb_firstname;
	private $fb_lastname;
	private $fb_params;
	private $fb_username;
	
	function __construct($fr=true){
		if(! file_exists("settings.php")){
			die("Settings file does not exist. Please create it.");
		}
		require("settings.php");
		if( @constant('TAURUS_FACEBOOK_ENABLED') && ! file_exists("keys/facebook.php")){
			die("Please define your keys in the facebook.php file or set FACEBOOK_ENABLED in settings.php to false.");
		}
		if(constant('TAURUS_FACEBOOK_ENABLED')){
			include("keys/facebook.php");
			new FacebookKeys();
			$this->fb_config = array("appId" => constant("TAURUS_FACEBOOK_APPID"), "secret" => constant("TAURUS_FACEBOOK_SECRET"), "fileUploads" => constant("TAURUS_FILE_UPLOADS"));
			$this->fb = new Facebook($this->fb_config);
			$this->fb_params = array("scope" => "publish_actions");
		}
		if(! defined("TAURUS_LANG")){
			define("TAURUS_LANG", "en_US");
		}
		if(! file_exists("translation/en_US.php")){
			die("Translation file is nonexistent. Please install the translation file(s) of the language you would like to translate to into the translations folder.");
		}
		include("translation/" . constant("TAURUS_LANG") . ".php");
		new Translation();
	}
	function logIn($username, $password){
		$hash=new PasswordHash(8, false);
		if ($hash->CheckPassword($password, @file_get_contents("login/$username.txt"))) {
			return true;
		}
		else {
			return false;
		}
	}
	function register($username, $password, $realname){
		if( file_exists("login/$username.txt")){
			return false;
		}
		$hash=new PasswordHash(8, false);
		if(! file_put_contents("login/$username.txt", $hash->HashPassword($password))){
			return false;
		}
		if(! file_put_contents("info/$username.txt", $realname)){
			return false;
		}
		return true;
	}
	function getInformation($username){
		$info=explode(file_get_contents("info/$username.txt"), "`");
		$rtme["username"] = $username;
		$rtme["realname"] = $info[0];
		return $rtme;
	}
	function getPost($id){
		return file_get_contents("posts/$id.txt");
	}
	function pageLogin($error){
		$this->pageengine(0);
		exit;
	}
	function pageHome($info){
		$this->pageengine("1.header");
?>
		<?php if(constant("TAURUS_FACEBOOK_ENABLED")){  ?>
		<h3><p align="center"><a href="http://facebook.com/"><?php echo constant("TAURUS_FACEBOOK"); ?></a> | <?php if($this->fb->getUser() == 0){  ?><a href="<?php echo $this->fb->getLoginUrl($this->fb_params); ?>"><?php echo constant("TAURUS_LANG_FACEBOOK_LOGIN"); ?></a><?php } else{ $this->fbsetup(); echo constant("TAURUS_LANG_FACEBOOK_SIGNED_IN_AS") . "<a href='http://facebook.com/" . $this->fb_username . "'>" . $this->fb_firstname . " " . $this->fb_lastname . "</a>"; } ?>.</p></h3>
		<?php
			}?>
	</body>
</html>
<?php
	}
	function page404(){
		header("HTTP/1.1 404 Not Found");
		$this->pageengine(-1);
	}
	function pageCSS(){
?>
@import url('http://fonts.googleapis.com/css?family=Bubblegum+Sans');
body {
	background-color:blue;
	font-family: 'Bubblegum Sans';
	color: white;
	background-image:url('img/stars.png');
}
navbar {
	position:fixed;
	background-color: #86abd9;
}
<?php
		exit;
	}
	function pageLogout(){
		setcookie("user", "", time()-3600);
		setcookie("pass", "", time()-3600);
		header("Location: ?pid=0");
		exit;
	}
	function pageLoader($page_id){
		if($page_id == 2){
			$this->pageCSS();
			exit;
		}
		elseif($page_id == 0){
			if(! @isset($_COOKIE['user']) && ! @isset($_COOKIE['pass'])){
				@$this->pageLogin();
			}
			else{
				if($this->logIn($_COOKIE['user'], $_COOKIE['pass'])){
					$this->pageHome($this->getInformation($_POST['username']));
				}
				else{
					$this->pageLogin(constant("TAURUS_LOG_IN_INCORRECT"));
				}
			}
		}
		elseif(@isset($_GET['login']) && ! @isset($_COOKIE['user']) && ! @isset($_COOKIE['pass'])){
			if(! @isset($_GET['username']) && !@isset($_POST['password'])){
				if($this->logIn($_POST['user'], $_POST['pass'])){
					setcookie("user", $_POST['user']);
					//TODO: hash this
					setcookie("pass", $_POST['pass']);
					$this->pageHome($this->getInformation($_POST['user']));
				}
				else{
					$this->pageLogin(constant("TAURUS_LOG_IN_INCORRECT"));
				}
			}
			else{
				$this->pageLogin(constant("TAURUS_LOG_IN_INCOMPLETE"));
			}
		}
		elseif($page_id == 1){
			if(! @$this->logIn($_COOKIE['user'], $_COOKIE['pass'])){
				$this->pageLogin(constant("TAURUS_LOG_IN_INCORRECT"));
			}
			else{
				$this->pageHome($this->getInformation($_COOKIE['user']));
			}
		}
		elseif($page_id == 4){
			$this->pageLogout();
			exit;
		}
		else{
			$this->page404();
		}
	}
	function fbsetup(){
		$user = $this->fb->api('/me');
		$this->fb_username = $user['username'];
		$this->fb_firstname = $user['first_name'];
		$this->fb_lastname = $user['last_name'];
		return;
	}
	function pageengine($page){
		if(! $contents=file_get_contents("pages/" . $page . ".page")){
			die("pageengine: Cannot access " . $page . ".");
		}
		#Here comes the fun part
		$contents=str_replace("{{TAURUS_NAME}}", constant("TAURUS_LANG_NAME"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN}}", constant("TAURUS_LANG_LOG_IN"), $contents);
		$contents=str_replace("{{TAURUS_NAME}}", constant("TAURUS_LANG_NAME"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN_INCORRECT}}", constant("TAURUS_LANG_LOG_IN_INCORRECT"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN_INCOMPLETE}}", constant("TAURUS_LANG_LOG_IN_INCOMPLETE"), $contents);
		$contents=str_replace("{{TAURUS_MOTTO}}", constant("TAURUS_LANG_MOTTO"), $contents);
		$contents=str_replace("{{TAURUS_HOME}}", constant("TAURUS_LANG_HOME"), $contents);
		$contents=str_replace("{{TAURUS_404TEXT}}", constant("TAURUS_LANG_404TEXT"), $contents);
		$contents=str_replace("{{TAURUS_404LINK}}", constant("TAURUS_LANG_404LINK"), $contents);
		$contents=str_replace("{{TAURUS_LOGOUT}}", constant("TAURUS_LANG_LOGOUT"), $contents);
		if(@isset($this->username)){
			$contents=str_replace("{{USERNAME}}", $this->username, $contents);
		}
		echo $contents;
	}
}