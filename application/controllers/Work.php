<?php

/**
 * Work service for the airline apps
 * 
 * This controller provides a number of services that a student
 * app can request.
 */
class Work extends CI_Controller {

	// constructor
	function __construct()
	{
		parent::__construct();

		// was a session token provided?
		$this->trader = NULL;
		$this->token = $this->input->get('key');
		if (!empty($this->token))
		{
			$prc_session = $this->trading->get($this->token);
			$this->trader = empty($prc_session) ? 'Bogus' : $prc_session->factory;
		}
	}

	/**
	 *  Normal entry point ... should never get here
	 */
	public function index()
	{
		redirect('/');
	}

	/**
	 * Register a new trading session for an app
	 * 
	 * @param	string	$team	team name
	 * @param   string  $password Super-secret access token for the team
	 * @return	The API key
	 */
	function registerme($team = NULL, $password = NULL)
	{
		$oops = '';

		// verify username (group) & password presence
		if (empty($team))
			$oops .= 'Team needed! ';
		if (empty($password))
			$oops .= 'Password needed! ';

		// check user validitity
		$factory = NULL; // assume the worst
		if (empty($oops))
		{
			$factory = $this->teams->get($team);
			if ($factory == NULL)
				$oops .= 'No such team! ';
		}

		// check the password, and its hash if needed
		if (empty($oops))
		{
			$okok = FALSE;
			if (strlen($team->token) < 8)
			{
				// original token still in place
				$okok = ($password == $team->token);
				$this->harden($team);
			} else
			{
				$okok = password_verify($password, $team->token);
			}
			if (!$okok)
				$oops .= 'Bad password! ';
		}

		// if anything went wrong, redisplay the page
		if (!empty($oops))
		{
			// ignore invalid credentials
			echo 'Oops: ' . $oops;
		} else
		{
			// otherwise, consider them good to go
//			$apikey = $this->engine->randomToken();

//			echo 'Ok ' . $apikey;
		}
	}

	// Convert plaintext token into hash, for better security
	private function harden($team)
	{
		$team->token = password_hash($team->token, PASSWORD_DEFAULT);
		$this->factories->update($team);
	}

	/**
	 * Destroy a team' PRC trading session
	 * 
	 * @param	string	$key	Team's API key (passed as query parameter)
	 * @return	 "Ok" or an error message
	 */
	function goodbye()
	{
//		// basic fact-checking
//		if (empty($this->trader))
//		{
//			echo "Oops: I don't recognize you!";
//			return;
//		}
//
//		$stat = $this->stats->get($this->trader);
//		$stat->balance = $this->properties->get('ante');
//		$this->stats->update($stat);
//
//		$records = $this->parts->some('plant', $this->trader);
//		if (!empty($records))
//			foreach ($records as $record)
//				$this->parts->delete($record->id);
//
//		$this->trading->delete($this->token);
//
//		$this->activity->record($this->trader, 'left the game.');
//		echo "Ok";
	}

}
