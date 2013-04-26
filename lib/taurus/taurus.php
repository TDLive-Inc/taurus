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

require('lib/phpass/PasswordHash.php');

class Taurus {
	function __construct(){
		if(! file_exists("settings.php")){
			die("Settings file does not exist. Please create it.");
		}
		include("settings.php");
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
		echo "
<html>
	<head>
				<link href='?pid=2' rel='stylesheet' type='text/css' />
		<title>" . constant("TAURUS_NAME") . ' / ' . constant("TAURUS_LOG_IN") . '</title>
	</head>
	<body>
		<center><p align="center" style="font-family: ' . "'Bubblegum Sans'" . ', cursive;"><h1><img src="img/logos/288x135.png"></h1><b><i>' . constant("TAURUS_MOTTO") . '</i></b></p><h2>' . constant("TAURUS_LOG_IN") . '</h2><br>';
		if(isset($error)) {
			echo '<font color="red">' . $error . '</font>';
		}
		echo '
			<form action="?login=true" method="POST">
				<input type="text" name="user" />
				<input type="password" name="pass" />
				<input type="submit" value="Log in" />
			</form>
		</center>
	</body>
</html>';
		exit;
	}
	function pageHome($info){
?>
<html>
	<head>
		<link href="?pid=2" rel="stylesheet" type="text/css">
		<title><?php echo constant("TAURUS_NAME") . " / " . constant("TAURUS_HOME"); ?></title>
	</head>
	<body>
		<div style="align: center;" id="navbar">
			<a href="?pid=1">
				<img src="img/logos/97x46.png" alt="Project Taurus"></img>
			</a>
			 | <a href="?pid=4"><?php echo constant("TAURUS_LOGOUT"); ?></a>
		</div>
		<p align="center">
			<img src="img/logos/288x135.png" alt="Project Taurus"></img>
		</p>
	</body>
</html>
<?php
	}
	function page404(){
		header("HTTP/1.1 404 Not Found");
?>
<html>
	<head>
		<link href="?pid=2" rel="stylesheet" type="text/css" />
		<title><?php echo constant("TAURUS_NAME"); ?> / 404 Not Found</title>
	</head>
	<body>
	<p align="center"><center>
		<h1>404 Not Found</h1>
		<?php echo constant("TAURUS_404TEXT"); ?><br><br>
		<a href="?pid=1"><?php echo constant("TAURUS_404LINK"); ?></a>
	</p></center>
	</body>
</html>
<?php
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
}