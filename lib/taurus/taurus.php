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

include("settings.php");

class Taurus {
	
	function logIn($username, $password){
		if(! file_get_contents("login/$username.txt")){
			return false;
		}
		if(file_get_contents("login/$username.txt") == crypt(SALT . $password)){
			return true;
		}
		else{
			return false;
		}
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
		echo '
<html>
	<head>
		<title>Taurus / Log In</title>
	</head>
	<body>
		<center><p align="center"><h1>Taurus</h1><h2>Log in</h1></p><br>';
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
				if(logIn($_POST['username'], $_POST['password'])){
					$this->page_home($this->getInformation($_POST['username']));
				}
				else{
					$this->page_login("Incorrect username/password!!");
				}
			}
			else{
				$this->page_login("Please fill out all of the fields.");
			}
		}
	}
}