<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Registry Class
 *
 * This class manages the registry object and its mapping to the database
 *
 * @package		Registry
 * @version		1.0
 * @author 		Richard Davey <info@richarddavey.com>
 * @copyright 	Copyright (c) 2011, Richard Davey
 * @link		https://github.com/richarddavey/codeigniter-registry
 * @todo 		Add option for encryption
 * @todo 		Add sub keys
 * @todo 		Make environment dependant
 */
class Registry {
	
	/**
	 * CodeIgniter instance
	 *
     */
	private $CI;
	
	/**
	 * DB registry values
	 *
     */
	private $registry;
	
	/**
	 * Override registry values
	 *
     */
	private $override;
	
	/**
	 * Default values
	 *
     */	
	private $reg_use_database		= FALSE;
	private $reg_table_name			= '';
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 */
	public function __construct($params = array())
	{
		if (count($params) > 0)
		{
			$this->initialize($params);
		}
		
		// set up CI classes
		$this->CI =& get_instance();
		
		// Are we using a database?  If so, load it
		if ($this->reg_use_database === TRUE AND $this->reg_table_name != '')
		{
			// ensure db is loaded
			$this->CI->load->database();
			
			// load registry
			$this->_registry_read();
		}
		
		log_message('debug', "Registry Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */
	private function initialize($params = array())
	{
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				if (in_array($key, array('reg_use_database', 'reg_table_name')) AND isset($this->$key))
				{
					$this->$key = $val;
				}
			}
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Getter Method
	 *
	 * @access	public
	 * @param	string	name
	 * @return	string
	 */
	public function __get($name) 
	{
		// call get method
		return $this->get_item($name);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Setter Method
	 *
	 * @access	public
	 * @param	string	name
	 * @param	string	value
	 * @return	void
	 */
	public function __set($name, $value) 
	{
		// call set method
		$this->set_item($name, $value);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Unset override registry item
	 *
	 * @access	public
	 * @param	string	name
	 * @return	void
	 */
	public function reset_item($name) 
	{
		// unset registry value
		unset($this->override->$name);
	}

	// --------------------------------------------------------------------
    
	/**
	 * Temporarily set registry item
	 *
	 * @access	public
	 * @param	string	name
	 * @param	string	value
	 * @return	void
	 */
	public function set_item($name, $value) 
	{
		// temp set registry value
		$this->override->$name = $value;
	}

	// --------------------------------------------------------------------

	/**
	 * Get value from registry
	 *
	 * @access	public
	 * @param	string	name
	 * @return	string
	 */
	public function get_item($name) 
	{
		// get registry value
		return isset($this->override->$name) ? $this->override->$name : (isset($this->registry->$name) ? $this->registry->$name : null);
	}
	
	// --------------------------------------------------------------------

	/**
	 * Load registry from database
	 *
	 * @return void
	 */
	private function _registry_read()
	{
		// get generic settings
		$query = $this->CI->db->get($this->reg_table_name);
		
		if ($query->num_rows() > 0) 
		{ 	
			
			// loop
			foreach ($query->result() as $row) 
			{
					
				// get results
				$this->registry->{$row->key} = $row->value;
			}
		}
	}
	
}
// END Registry Class

/* End of file Registry.php */
/* Location: ./application/libraries/Registry.php */