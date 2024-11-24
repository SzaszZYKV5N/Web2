<?php

class SoapKliens_Controller
{
	public $baseName = 'soapKliens'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>