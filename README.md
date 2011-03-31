# CodeIgniter-Registry

CodeIgniter-Registry is a Windows style DB based Registry library for web applications built upon CodeIgniter.

You can link the registry to a database to set default values from a table. These values can be overwritten throughout your application and reset back to the default as necessary.


## Requirements

* CodeIgniter 2.0.x


## Installation

In order to have database functionality, you must first create a database table for this purpose. Here is the basic prototype (for MySQL) required by the registry class:

	CREATE TABLE `registry` (
		`key` varchar(50) NOT NULL default '',
		`value` varchar(200) default NULL,
		PRIMARY KEY  (`key`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8

Also make sure to point to this table in your config file.


## Example

	// get registry item
	$this->registry->example;
	
	// alternate get registry item
	$this->registry->get_item('example');
	
	// set registry item
	$this->registry->example = 'Hello World';
	
	// alternate set registry item
	$this->registry->set_item('example', 'Hello World');
	
	// reset item back to default value
	$this->registry->reset_item('example');