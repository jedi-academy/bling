<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends Application {

	private $items_per_page = 10;
	private $members = null;

	// constructor
	public function __construct()
	{
		parent::__construct();
		$this->members = $this->teams->all();
	}

	public function index()
	{
		$this->grid();
	}

	// Show a single page of results
	private function show_page($extract)
	{
		$this->data['pagetitle'] = 'Team List';

		$result = ''; // start with an empty array		
		foreach ($extract as $record)
		{
			$result .= $this->parser->parse('team_one', (array)$record, true);
		}
		$this->data['display_set'] = $result;

		// and then pass them on
		$this->data['pagebody'] = 'team_list';
		$this->render();
	}

	// Extract & handle a page of items, defaulting to the beginning
	function page($num = 1)
	{
		$extract = array(); // start with an empty extract
		// use a foreach loop, because the record indices may not be sequential
		$index = 0; // where are we in the tasks list
		$count = 0; // how many items have we added to the extract
		$start = ($num - 1) * $this->items_per_page;
		foreach ($this->members as $record)
		{
			if ($index++ >= $start)
			{
				$extract[] = $record;
				$count++;
			}
			if ($count >= $this->items_per_page)
				break;
		}

		$this->data['pagination'] = $this->pagenav($num);
		$this->show_page($extract);
	}

	// Build the pagination navbar
	private function pagenav($num)
	{
		$lastpage = ceil($this->teams->size() / $this->items_per_page);
		$parms = array(
			'first' => 1,
			'previous' => (max($num - 1, 1)),
			'next' => min($num + 1, $lastpage),
			'last' => $lastpage,
			'base' => 'members'
		);
		return $this->parser->parse('team_nav', $parms, true);
	}

	// take a closer look at one plant
	function inspect($which = null)
	{

		$this->data['previous_view'] = $_SERVER['HTTP_REFERER'];

		$record = null;
		if ($which != null)
			$record = $this->teams->get($which);
		if ($record == null)
		{
			$this->page(1);
			return;
		}

		// avatar
		$frag = empty($record->org) ? 'team_icon' : 'team_avatar';
		$record->thumbnail = $this->parser->parse($frag, (array) $record, true);

		// and away we go
		$this->data = array_merge($this->data, (array) $record);
		$this->data['pagebody'] = 'team_inspect';
		$this->render();
	}

	// present all the airlines in a grid
	function grid()
	{
		$this->data['pagetitle'] = 'Teams';

		// build the presentation grid
		$result = ''; // start with an empty array		
		foreach ($this->members as $record)
		{
			// determine the avatar to use
			$frag = empty($record->org) ? 'team_icon' : 'team_avatar';
			$record->thumbnail = $this->parser->parse($frag, (array) $record, true);

			$frag_template = empty($record->org) ? 'inactive_cell' : 'team_cell';
			$result .= $this->parser->parse($frag_template, (array) $record, true);
		}
		$this->data['display_set'] = $result;

		// and then pass them on
		$this->data['pagebody'] = 'team_grid';
		$this->render();
	}

}
