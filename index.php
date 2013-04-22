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

include("lib/taurus/taurus.php");

$taurus = new Taurus;
if( @isset($_GET['testdata'])){
	$taurus->register("test", "tester", "Taurus Test");
	$taurus->pageLogin("Test data created.");
}
if(! @isset($_GET['pid']) && ! @isset($_GET['login'])){
	if(! @isset($_COOKIE['user']) && ! @isset($_COOKIE['pass'])){
		$taurus->pageLoader(0);
	}
	else{
		$taurus->pageLoader(1);
	}
}
elseif(@isset($_GET['pid'])){
	$taurus->pageLoader($_GET['pid']);
}
else{
	$taurus->pageLoader(-1);
}

?>