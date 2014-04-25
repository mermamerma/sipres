<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


// ------------------------------------------------------------------------

/**
 * Text Input Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_input'))
{
	function form_input($data = '', $value = '', $extra = '')
	{
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'id' => (( ! is_array($data)) ? $data : ''),  'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}


// ------------------------------------------------------------------------


/**
 * Date Picker 
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_date_picker'))
{
	function form_date_picker($data = '', $value = '', $extra = '')
	{			
		$default_day = ($value == 'hoy') ? " $('#$data').datepicker('setDate', 'today'); " : '';
		$defaults = array('type' => 'text', 'name' => (( ! is_array($data)) ? $data : ''), 'id' => (( ! is_array($data)) ? $data : ''),  'value' => $value);
		$parse_id = array('id' => (( ! is_array($data)) ? $data : ''));
		$id = $parse_id['id'];
		$default_day = ($value == 'hoy') ? " $('#$id').datepicker('setDate', 'today'); " : '';
		#var_dump($id);
		#echo _parse_form_attributes($data,$defaults);
		$out  =  "<input "._parse_form_attributes($data, $defaults).$extra."/>";
		$out .= "<script type=\"text/javascript\">						
			  	$(function() { $( \"#$id\" ).datepicker({ 
						changeMonth: true, 
						changeYear: true, 
						regional: 'es',
						showOn: 'button',			  												
						buttonImage: '".base_url()."public/images/calendar.gif',
						buttonImageOnly: true
					}); 
					$default_day
				});
				
			  	</script>" ;
		return  $out ; 
	}
}

/**
 * Textarea field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_textarea'))
{
	function form_textarea($data = '', $value = '', $extra = '')
	{
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''),'id' => (( ! is_array($data)) ? $data : ''), 'cols' => '90', 'rows' => '12');

		if ( ! is_array($data) OR ! isset($data['value']))
		{
			$val = $value;
		}
		else
		{
			$val = $data['value']; 
			unset($data['value']); // textareas don't use the value attribute
		}
		
		$name = (is_array($data)) ? $data['name'] : $data;
		return "<textarea "._parse_form_attributes($data, $defaults).$extra.">".form_prep($val, $name)."</textarea>";
	}
}

// ------------------------------------------------------------------------

/**
 * Hidden Input Field
 *
 * Generates hidden fields.  You can pass a simple key/value string or an associative
 * array with multiple values.
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_hidden'))
{
	function form_hidden($name, $value = '', $recursing = FALSE)
	{
		static $form;

		if ($recursing === FALSE)
		{
			$form = "\n";
		}

		if (is_array($name))
		{
			foreach ($name as $key => $val)
			{
				form_hidden($key, $val, TRUE);
			}
			return $form;
		}

		if ( ! is_array($value))
		{
			$form .= '<input type="hidden" name="'.$name.'" id="'.$name.'"  value="'.form_prep($value, $name).'" />'."\n";
		}
		else
		{
			foreach ($value as $k => $v)
			{
				$k = (is_int($k)) ? '' : $k; 
				form_hidden($name.'['.$k.']', $v, TRUE);
			}
		}

		return $form;
	}
}

if ( ! function_exists('form_dropdown'))
{
	function form_dropdown($name = '', $options = array(), $extra = '', $selected = array())
	{
		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		#$form  = '<select name="'.$name.'" 	id="'.$name."'.$extra.$multiple.">\n";
		
		$form = '<select name="'.$name.'"	id="'.$name.'"'.$extra.$multiple.">\n";
		
		#$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}


if ( ! function_exists('form_dropdown_db'))
{
	function form_dropdown_db($name = '', $tabla = '',  $extra = '', $selected = array() )
	{	
		$CI		= & get_instance();
		$query 	= $CI->db->query("SELECT id_$tabla, nombre_$tabla FROM $tabla ORDER BY nombre_$tabla ASC");
		#die($CI->db->last_query() );
		$options = array(''=>'[Seleccione...]');			
		
		if ($query->num_rows() > 0)	{
			#$options [] = array(''=>'Seleccione');
			foreach ($query->result_array() as $row){
				#$options[] = $row["nombre_$tabla"];
				$options[$row["id_$tabla"]] = $row["nombre_$tabla"];
			}
		} 

		/*
		foreach ($sql->result() as $key => $value)
		{
			   $array[$key] = $value;
		}
		 *
		 */
		#die(var_dump($options));
		#return $form;
		return form_dropdown($name, $options, $extra);
		#return form_dropdown("id_$tabla", $options);
	}
}

if ( ! function_exists('form_dropdown_custom'))
{
	function form_dropdown_custom($id, $sql,  $extra = '', $selected = array() )
	{	
		$CI		= & get_instance();
		$query 	= $CI->db->query($sql);		
		$options = array(''=>'[Seleccione...]');			
		
		if ($query->num_rows() > 0)	{			
			foreach ($query->result_array() as $row){				
				$options[$row["clave"]] = $row["valor"];
			}
		} 
		return form_dropdown($id, $options);
	}
}

if ( ! function_exists('form_autocomplete')){
	function form_autocomplete($id,$input, $base_url, $p, $id_val='',$input_val='')	{
		$str  = '';
		$str .= form_hidden("$id");
		$str .= form_input("$input");		
		$str .= <<<EOF
<script type="text/javascript">
function seleccionado_$p(codigo){
	$('#$id').val(codigo);
}
$('#$id').val("$id_val");
$('#$input').val("$input_val");
$('#$input').autocomplete({
 source: "$base_url?c=search&m=search_autocomplete&p1=$p",
	minLength: 2,
	select: function(event, ui){
			//log(ui.item ? ("Selected: " + ui.item.label) : "Nothing selected, input was " + this.value);
			seleccionado_$p(ui.item ? (ui.item.id):"");
	}
	}).data( "autocomplete" )._renderItem = function( ul, item ) {
	
	if (item.label!=item.nombre){
	return $( "<li></li>" )
	.data( "item.autocomplete", item )
	.append( "<a style='text-align:left'>" + item.label + "<br></a>" )
	.appendTo( ul );
	}                };
</script>
EOF;
		return $str;
	}
}
