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
		define('TAURUS_LANG_TRANSLATION_VALUE', 'VALUE');
		define('TAURUS_LANG_NAME', 'Taurus');
		define('TAURUS_LANG_LOG_IN', 'Log in');
		define('TAURUS_LANG_LOG_IN_INCORRECT', 'Log in incorrect!!');
		define('TAURUS_LANG_LOG_IN_INCOMPLETE', 'Log in form incomplete. Please complete this form and try again.');
		define('TAURUS_LANG_MOTTO', 'All your social networking in one place.');
		define('TAURUS_LANG_HOME', 'Home');
		define('TAURUS_LANG_404TEXT', "We're sorry, but the page you were looking for wasn't found.");
		define('TAURUS_LANG_404LINK', 'Go back to the home page');
		define('TAURUS_LANG_LOGOUT', 'Log out');
		define('TAURUS_LANG_FACEBOOK', 'Facebook');
		define('TAURUS_LANG_FACEBOOK_LOGIN', 'Log into Facebook');
		define('TAURUS_LANG_FACEBOOK_SIGNED_IN_AS', 'Signed in as ');
	}
}
?>