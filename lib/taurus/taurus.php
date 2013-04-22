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
		if(! file_get_contents("login/$username.txt")){
			return false;
		}
		if(file_get_contents("login/$username.txt") == crypt(constant("TAURUS_SALT") . $password)){
			return true;
		}
		else{
			return false;
		}
	}
	function register($username, $password){
		if( file_exists("login/$username.txt")){
			return false;
		}
		if(! file_put_contents("login/$username.txt", crypt(constant('TAURUS_SALT') . $password))){
			return false;
		}
		return true;
	}
	function getInformation($username){
		$info=explode(file_get_contents("info/$username.txt"), "`");
		$rtme["username"] = $username;
		$rtme["realname"] = $info[0];
		return $info;
	}
	function getPost($id){
		return file_get_contents("posts/$id.txt");
	}
	function pageLogin($error){
		echo "
<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Bubblegum+Sans' rel='stylesheet' type='text/css'>
		<title>" . constant("TAURUS_NAME") . ' / ' . constant("TAURUS_LOG_IN") . '</title>
	</head>
	<body>
		<center><p align="center" style="font-family: ' . "'Bubblegum Sans'" . ', cursive;"><h1>' . constant("TAURUS_NAME") . '</h1><b><i>' . constant("TAURUS_MOTTO") . '</i></b></p><h2>' . constant("TAURUS_LOG_IN") . '</h2><br>';
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
	function pageLoader($page_id){
		if($page_id == 0){
			@$this->pageLogin();
		}
		if(@isset($_GET['login'])){
			if(@isset($_GET['username']) && $_POST['password']){
				if(logIn($_POST['user'], $_POST['pass'])){
					$this->page_home($this->getInformation($_POST['username']));
				}
				else{
					$this->pageLogin(constant("TAURUS_LOG_IN_INCORRECT"));
				}
			}
			else{
				$this->pageLogin(constant("TAURUS_LOG_IN_INCOMPLETE"));
			}
		}
	}
}