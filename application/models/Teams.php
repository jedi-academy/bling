<?php

class Teams extends MY_Model {

	// constructor
	function __construct()
	{
		parent::__construct('teams', 'id');
	}

	// look for a specific repo
	public function findRepo($org = null, $repo = null)
	{
		if (empty($org) || empty($repo))
			return NULL;
		$all = $this->all();
		foreach ($all as $record)
		{
			if (($record->org == $org) && ($record->repo == $repo))
				return $record;
		}
		return NULL;
	}

	// provide form validation rules
	public function rules()
	{
		$config = array(
			['field' => 'org', 'label' => 'Organization name', 'rules' => 'alpha_dash|max_length[64]'],
			['field' => 'repo', 'label' => 'Repository name', 'rules' => 'alpha_dash|max_length[64]'],
			['field' => 'branch', 'label' => 'Repository branch', 'rules' => 'in_list[master,develop]'],
			['field' => 'website', 'label' => 'Website location', 'rules' => 'alpha_dash'],
		);
		return $config;
	}

}
