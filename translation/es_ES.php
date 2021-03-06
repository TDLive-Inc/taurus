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
		define('TAURUS_NAME', 'Tauro');
		define('TAURUS_LOG_IN', 'iniciar la sesión');
		define('TAURUS_LOG_IN_INCORRECT', 'Iniciar sesión incorrectos!');
		define('TAURUS_LOG_IN_INCOMPLETE', 'Iniciar sesión de manera incompleta. Por favor complete este formulario y vuelva a intentarlo.');
		define('TAURUS_MOTTO', 'Todas tus redes sociales en un solo lugar.');
		define('TAURUS_HOME', 'casa');
		define('TAURUS_404TEXT', "Lo sentimos, pero la página que buscas no se ha encontrado.");
		define('TAURUS_404LINK', 'Volver a la página principal');
		define('TAURUS_LOGOUT', 'finalizar la sesión');
	}
}
?>