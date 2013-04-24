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

class Translation extends Taurus {
	function __construct(){
		define('TAURUS_TRANSLATION_VALUE', 'VALUE');
		define('TAURUS_NAME', 'Taureau');
		define('TAURUS_LOG_IN_INCORRECT', 'Login incorrect!!');
		define('TAURUS_LOG_IN_INCOMPLETE', 'Login form incomplete. Please complete this form and try again.');
		define('TAURUS_MOTTO', "Toutes vos réseaux sociaux en un seul endroit.");	
	}
}
?>