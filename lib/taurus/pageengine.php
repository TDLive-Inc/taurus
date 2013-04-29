<?php

class PageEngine extends Taurus {
	public $page;
	function __construct($page){
		if(! file_exists("../../pages/$page.page")){
			die("TranslationsEngine: Page $page does NOT exist.");
		}
		$this->page = $page;
	}
	function engine(){
		if(! $contents=file_get_contents("../../pages/" . $this->page . ".page")){
			die("TranslationsEngine: Cannot access " . $this->page . ".");
		}
		#Here comes the fun part
		$contents=str_replace("{{TAURUS_NAME}}", constant("TAURUS_NAME"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN}}", constant("TAURUS_LOG_IN"), $contents);
		$contents=str_replace("{{TAURUS_NAME}}", constant("TAURUS_NAME"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN_INCORRECT}}", constant("TAURUS_LOG_IN_INCORRECT"), $contents);
		$contents=str_replace("{{TAURUS_LOG_IN_INCOMPLETE}}", constant("TAURUS_LOG_IN_INCOMPLETE"), $contents);
		$contents=str_replace("{{TAURUS_MOTTO}}", constant("TAURUS_MOTTO"), $contents);
		$contents=str_replace("{{TAURUS_HOME}}", constant("TAURUS_HOME"), $contents);
		$contents=str_replace("{{TAURUS_404TEXT}}", constant("TAURUS_LOG_IN_INCORRECT"), $contents);
		$contents=str_replace("{{TAURUS_404LINK}}", constant("TAURUS_LOG_IN_INCORRECT"), $contents);
		$contents=str_replace("{{TAURUS_LOGOUT}}", constant("TAURUS_LOG_IN_INCORRECT"), $contents);
	}
}