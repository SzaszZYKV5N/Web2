<?php

class Tcpdfminta_Controller
{
	public $baseName = 'tcpdfminta'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>