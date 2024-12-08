<?php

class Admin_Controller
{
	public $baseName = 'admin'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>