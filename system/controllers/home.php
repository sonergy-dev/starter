<?php

/**
 *
 */
class Home extends Controller
{

	public function index($name = '', $otherName = '')
	{
		$data = "";
		//$name = "";
		if(isset($name) && $name == "become-a-driver"){
			$this->view('home/driver');
		}else{
			// $this->view('home/index', $data);
			$this->view('home/index', $data);
		}
		
	}

	

	
	public function referal($value='')
	{
		if (setcookie( "refer", $value, time()+96000 * 50, '/')){
				redirect_to("/");
		}
	}
}
