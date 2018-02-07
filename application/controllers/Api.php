<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// Service end-point for plant apps

class Api extends Application
{

	public function index()
	{
		$this->data['pagebody'] = 'coming_soon';
		$this->render(); 
	}

}
