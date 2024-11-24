<?php

class Elerhetoseg_alapinfok_Controller
{
	public $baseName = 'elerhetoseg_alapinfok';  
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>