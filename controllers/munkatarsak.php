<?php

class Munkatarsak_Controller
{
	public $baseName = 'munkatarsak';  
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>