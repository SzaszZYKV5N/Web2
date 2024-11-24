<?php

class Restkliens_Controller
{
	public $baseName = 'restKliens'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>