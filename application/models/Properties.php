<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Properties model.
 * A key/value set persisted in a DB table.
 * Similar to a java.util.properties
 */
class Properties extends CI_Model {

	// Fields
	var $_data = array();	 // Container for the data from persistent
	// storage (the database).
	var $_tableName;	// name of the DB table holding the data
	var $_keyField;	 // name of the primary key field
	var $_valueField;	  // name of the data field

	// Constructor

	function __construct()
	{
		parent::__construct($table = 'properties', $key = 'id', $value = 'value');

		// prime our state
		$this->_tableName = $table;
		$this->_keyField = $key;
		$this->_valueField = $value;

		// load the database table
		$query = $this->db->get($this->_tableName);
		foreach ($query->result_array() as $row)
		{
			$this->_data[$row[$this->_keyField]] = $row[$this->_valueField];
		}
	}

	// Clear the properties table
	function clear()
	{
		$this->_data = array();
	}

	// Does a key exist?
	function contains($key)
	{
		return isset($this->_data[$key]);
	}

	// Return the value associated with a key
	function get($key)
	{
		if (isset($this->_data[$key]))
			return $this->_data[$key];
		return null;
	}

	// Modify the value associated with a key & persist
	function put($key, $value)
	{
		$newData = array(
			$this->_keyField => $key,
			$this->_valueField => $value
		);
		if ($this->contains($key))
		{
			$this->db->where($this->_keyField, $key);
			$this->db->update($this->_tableName, $newData);
		} else
		{
			$this->db->insert($this->_tableName, $newData);
		}
		$this->_data[$key] = $value;
	}

	function debug($msg)
	{
		$temp = array();
		$temp['msg'] = $msg;
		$this->load->view('debug', $temp);
	}

	// Remove a property
	function remove($key)
	{
		unset($this->_data[$key]);
		$this->db->where($this->_keyField, $key);
		$this->db->delete($this->_tableName);
	}

	// Return the number of properties
	function size()
	{
		return count($this->_data);
	}

	// Return the entire set of properties, as an array
	function toArray()
	{
		return $this->_data;
	}

}
