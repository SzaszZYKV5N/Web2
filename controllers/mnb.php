<?php

class Mnb_Controller
{
	public $baseName = 'MNB'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>