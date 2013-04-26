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
		define('TAURUS_LOG_IN', 'Connexion');
		define('TAURUS_LOG_IN_INCORRECT', 'Connexion incorrecte!');
		define('TAURUS_LOG_IN_INCOMPLETE', "Connectez-forme incomplète. S'il vous plaît remplir ce formulaire et réessayez.");
		define('TAURUS_MOTTO', "Toutes vos réseaux sociaux en un seul endroit.");	
		define('TAURUS_HOME', 'maison');
		define('TAURUS_404TEXT', "Nous sommes désolés, mais la page que vous cherchez est introuvable.");
		define('TAURUS_404LINK', "Retour à la page d'accueil");
		define('TAURUS_LOGOUT', 'Déconnexion');
	}
}
?>