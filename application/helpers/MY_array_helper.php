<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
* 
* Convert an query to array for select form 
*
* @@author  Author(s): Jesus Rodriguez
* @access   public
* @param    array	fieds
* @param   	bool	insert an option in firts with value -1 and label Seleccione...   
* @return   array
*/  

if ( ! function_exists('array_select_form'))
{
	function array_select_form($query, $required = true){
			$campos = array('id_mision', 'nombre');
			$filas = array();
			if ($required)
				$filas = array('-1' => '[Seleccione...]');
			
			if($query->num_rows()>0){
				   	foreach($query->result_array() as $row){
	            	$filas[$row[$campos[0]]]= $row[$campos[1]];        
	        	}
	        	return $libros;
			}
			return false;
	    
		}
}


/**
* 
* Convert an object to array associative 
*
* @@author  Author(s): Juan Rabadan
* @access   public
* @param    object   
* @return   array
*/  

function array_to_array($query, $required = true){
	$filas = array();
	if ($required == true)
		$filas = array('' => '[Seleccione...]');		
	
	foreach($query as $row)
    	$filas[$row['id']]= $row['nombre'];        
        
     return $filas;
}

if ( ! function_exists('object_to_array'))
{
	function object_to_array($object)
	{
	    if (is_object($object))
	    {
	        foreach ($object as $key => $value)
	        {
	            $array[$key] = $value;
	        }
	    }
	    else
	    {
	        $array = $object;
	    }
	    return $array;
	}
}
	

/**
* 
* Convert an array to object 
*
* @@author  Author(s): Juan Rabadan
* @access   public
* @param    array associative   
* @return   object
*/  

if ( ! function_exists('array_to_object'))
{
	function array_to_object($array) 
	{
		if (is_array($array))
		{
			$obj = new StdClass();
			foreach ($array as $key => $val)
			{
				$obj->$key = $val;
			}
		}
		else 
		{ 
			$obj = $array; 
		}
		return $obj;
	}
}

function objectToArray( $object )
    {
        if( !is_object( $object ) && !is_array( $object ) )
        {
            return $object;
        }
        if( is_object( $object ) )
        {
            $object = get_object_vars( $object );
        }
        return array_map( 'objectToArray', $object );
    }