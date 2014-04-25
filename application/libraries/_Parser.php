<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* CodeIgniter
*
* An open source application development framework for PHP 4.3.2 or newer
*
* @package        CodeIgniter
* @author        Rick Ellis
* @copyright    Copyright (c) 2006, EllisLab, Inc.
* @license        http://www.codeignitor.com/user_guide/license.html
* @link        http://www.codeigniter.com
* @since        Version 1.0
* @filesource
*/

// ------------------------------------------------------------------------

/**
* MY Parser Class
*
* Added a feature so when a template is passed, if all the variable
* replacement tags are not replaced they are removed from the
* returned output. Thus making the returned string cleaner.
*
* @package		CodeIgniter
* @subpackage	Libraries
* @category		Parser
* @author		Jesús Rodríguez
*/

class MY_Parser extends CI_Parser{
    var $l_delim = '{%';
	var $r_delim = '%}';
	/**
	 *  Parse a template
	 *
	 * Parses pseudo-variables contained in the specified template,
	 * replacing them with the data in the second param, 
	 * and clean the variables that have not been set
	 *
	 * @access	public
	 * @param	string
	 * @param	array
	 * @param	bool
	 * @return	string
	 */

	function _parse($template, $data, $return = FALSE)
	{
		if ($template == '')
		{
			return FALSE;
		}

		foreach ($data as $key => $val)
		{
			if (is_array($val))
			{
				$template = $this->_parse_pair($key, $val, $template);
			}
			else
			{
				$template = $this->_parse_single($key, (string)$val, $template);
			}
		}
		
		#$template = preg_replace('/\{.*\}/','',$template);
		$patron = '/\\'.$this->l_delim.'.*\\'.$this->r_delim.'/';
		#die($patron);
		$template = preg_replace($patron,'',$template);
		if ($return == FALSE)
		{
			$CI =& get_instance();
			$CI->output->append_output($template);
		}

		return $template;
	}
	
}


/* End of file MY_Parser.php */
/* Location: /application/libraries/MY_Parser.php */