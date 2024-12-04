<?php

class Tcpdf_Controller
{
	public $baseName = 'tcpdf'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>