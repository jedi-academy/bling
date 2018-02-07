<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Help extends Application {

	public function index()
	{
		$data = file_get_contents('../data/help_page.md');
		$result = $this->parsedown->text($data);
		$this->data['content'] = $this->parser->parse_string($result, $this->data, true);
		$this->render();
	}

}
