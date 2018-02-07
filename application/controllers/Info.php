<?php

/**
 * Information service for WACKY.
 * 
 * This controller provides access to all sorts of useful information
 * about goings on inside the simulation.
 * 
 * This is a RESTish service controller, in that it returns data in JSON form.
 * 
 */
class Info extends CI_Controller
{

	// constructor, for prep
	function __construct()
	{
		parent::__construct();
	}

	/**
	 *  Normal entry point ... should never get here
	 */
	public function index()
	{
		redirect('/');
	}

	public function airplanes($which = null)
	{
		if ($which == null)
			echo json_encode($this->airplanes->all(), JSON_PRETTY_PRINT);
		else
			echo json_encode($this->airplanes->get($which), JSON_PRETTY_PRINT);
	}

	public function airports($which = null)
	{
		if ($which == null)
			echo json_encode($this->airports->all(), JSON_PRETTY_PRINT);
		else
			echo json_encode($this->airports->get($which), JSON_PRETTY_PRINT);
	}

	public function airlines($which = null)
	{
		if ($which == null)
			echo json_encode($this->airlines->all(), JSON_PRETTY_PRINT);
		else
			echo json_encode($this->airlines->get($which), JSON_PRETTY_PRINT);
	}

	public function regions($which = null)
	{
		if ($which == null)
			echo json_encode($this->regions->all(), JSON_PRETTY_PRINT);
		else
			echo json_encode($this->regions->get($which), JSON_PRETTY_PRINT);
	}

}
