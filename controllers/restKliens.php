<?php

class Restkliens_Controller
{
	public $baseName = 'restkliens'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>