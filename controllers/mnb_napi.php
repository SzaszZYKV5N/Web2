<?php

class MNB_napi_Controller
{
	public $baseName = 'MNB_napi'; 
	public function main(array $vars) 
	{
		
		$view = new View_Loader($this->baseName."_main");
	}
}

?>