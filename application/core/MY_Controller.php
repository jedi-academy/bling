<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2016, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	protected $trader = null;	// who is asking?
	protected $token = null;	// what token did they provide?
	
	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */
	function __construct()
	{
		parent::__construct();

		//  Set basic view parameters
		$this->data = array();
		$this->data['pagetitle'] = 'Bling Accessories';
		$this->data['title'] = 'Bling Accessories';
		$this->data['ci_version'] = (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '';

		// login scoop?
		$this->data['userRole'] = ROLE_GUEST;

		$this->data['userID'] = $this->session->userdata('userID') ?? 'Guest';
		$this->data['userName'] = $this->session->userdata('userName') ?? '';
		$this->data['userRole'] = $this->session->userdata('userRole') ?? 'guest';

		$this->data['zzz'] = '';
		$this->data['alerts'] = '';
		$this->error_free = TRUE;
			
		// was a WAC session token provided?
		$this->trader = NULL;
		$this->token = $this->input->get('key');
		if (!empty($this->token)) {
			$wac_session = $this->trading->get($this->token);
			$this->trader = empty($wac_session) ? '' : $wac_session->factory;
		}
	}

	/**
	 * Render this page
	 */
	function render($template = 'template')
	{
		// Massage the menubar
		$logstate = (empty($this->data['userName'])) ? 'notloggedin' : 'loggedin';
		$this->data['menubar'] = $this->parser->parse('theme/' . $logstate, $this->data, true);

		// integrate any needed CSS framework & components
		$this->data['caboose_styles'] = $this->caboose->styles();
		$this->data['caboose_scripts'] = $this->caboose->scripts();
		$this->data['caboose_trailings'] = $this->caboose->trailings();

		if (empty($this->data['content']))
			$this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
		$this->parser->parse('theme/template', $this->data);
	}

	/**
	 * RBAC - role-based access control.
	 * Restrict the access of a page to only those users
	 * who have the role specified.
	 * 
	 * @param string $roleNeeded 
	 */
	function restrict($roleNeeded = null)
	{
		$userRole = $this->session->userdata('userRole');
		if ($roleNeeded != null)
		{
			if ($userRole != $roleNeeded)
			{
				redirect("/");
				exit;
			}
		}
	}

	/**
	 * Are we logged in? 
	 */
	function loggedin()
	{
		return $this->session->userdata('userID');
	}

	/**
	 * Is the logged in user in a specific role? 
	 */
	function in_role($role)
	{
		if ($this->loggedin())
		{
			return ($role == $this->session->userdata('userRole'));
		}
	}

	/**
	 * Forced logout
	 */
	function logout()
	{
		$this->session->sess_destroy();
		redirect('/');
	}

	// Add an alert to the rendered page
	function alert($message = '', $context = 'success')
	{
		$parms = ['message' => $message, 'context' => $context];
		$this->data['alerts'] .= $this->parser->parse('theme/_alert', $parms, true);
		$this->error_free = FALSE;
	}

}
