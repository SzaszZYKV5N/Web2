<?php

class Mnb_napi_Controller
{
	public $baseName = 'mnb_napi'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>