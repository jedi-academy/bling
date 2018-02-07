<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vault extends Application
{

	public function __construct()
	{
		parent::__construct();
//		$this->restrict([ROLE_TEAM,ROLE_ADMIN]);
		$this->data['pagetitle'] = 'Team settings';
		$this->load->helper('formfields');
	}

	// show the login page
	public function index()
	{
		// if already logged in, proceed to setup
		if ( ! empty($this->data['userName']))
			$this->settings();
		else
		{
			$this->data['pagebody'] = 'vault';
			$this->render();
		}
	}

	// Validate a user login attempt
	public function login()
	{
		// verify username (group) & password
		$user = $this->input->post('group');
		if (empty($user))
			$this->alert('Team code needed', 'danger');

		$pw = $this->input->post('password');
		if (empty($pw))
			$this->alert('Access token needed', 'danger');

		// check user validitity
		$team = NULL; // assume the worst
		if ($this->error_free)
		{
			$team = $this->teams->get($user);
			if ($team == NULL)
				$this->alert('Unrecognized team', 'danger');
		}

		// check the password, and its hash if needed
		if ($this->error_free)
		{
			$okok = FALSE;
			if (strlen($team->token) < 8)
			{
				// original token still in place
				$okok = ($pw == $team->token);
				$this->harden($team);
			}
			else
			{
				$okok = password_verify($pw, $team->token);
			}
			if ( ! $okok)
				$this->alert('Invalid token', 'danger');
		}

		// if anything went wrong, redisplay the page
		if ( ! empty($this->data['alerts']))
		{
			$this->data['pagebody'] = 'vault';
			$this->render();
		}
		else
		{
			// otherwise, consider them good to go
			$this->session->set_userdata('team', $team);
			$this->session->set_userdata('userName', $user);
			$this->session->set_userdata('userID', $user);
			$this->session->set_userdata('userRole', ROLE_PLANT);
			redirect('/');
		}
	}

	// Convert plaintext token into hash, for better security
	private function harden($team)
	{
		$factory->token = password_hash($team->token, PASSWORD_DEFAULT);
		$this->teams->update($team);
	}

	// present the settings maintenance form
	public function settings()
	{
		$team = $this->session->userdata('team');
		$fields = array(
			'forg'		 => makePrefixedField('Your Organization', 'org', $team->org, 'https://github.com/', "Name of your team's organization on Github."),
			'frepo'		 => makePrefixedField('Your Repository', 'repo', $team->repo, 'https://github.com/.../', "Name of your team repository, inside the above organization."),
			'fbranch'	 => makeRadioButtons('Branch to Deploy', 'branch', $team->branch, ['master' => 'master', 'develop' => 'develop'], "Which branch would you like automatically deployed for testing?"),
			'fwebsite'	 => makePrefixedField('External website?', 'website', $team->website, 'https://', "URL for your team website, if not hosted on Umbrella's server. " .
					"This is important for the final assignment, when other plants will want to buy or sell parts with you."),
			'zsubmit'	 => makeSubmitButton('Update my settings', "Click on home or <back> if you don't want to change anything!", 'btn-success'),
		);
		$this->data = array_merge($this->data, $fields);

		$this->data['pagebody'] = 'settings';
		$this->render();
	}

	// handle a settings update request
	public function update()
	{
		// setup for validation
		$this->load->library('form_validation');
		$this->form_validation->set_rules($this->teams->rules());

		// retrieve & update data transfer buffer
		$team = (array) $this->session->userdata('team');
		$team = array_merge($team, $this->input->post());
		$this->session->set_userdata('team', (object) $team);

		// validate away
		if ($this->form_validation->run())
		{
			$team->updated = date('Y-m-d H:i:s.');
			$this->teams->update($team);
			$this->alert('Settings updated', 'success');
		}
		else
		{
			$this->alert('<strong>Validation errors!<strong><br>' . validation_errors(), 'danger');
		}
		$this->settings();
	}

}
