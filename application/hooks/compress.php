<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	function compress(){
		$CI =& get_instance();
		$buffer = $CI->output->get_output();

		$search = array('/\>[^\S ]+/s', '/[^\S ]+\</s', '/(\s)+/s');
		$replace = array('>', '<', '\\1');
		$new_buffer = preg_replace($search, $replace, $buffer);

		if ($new_buffer === null){
			$new_buffer = $buffer;
		}

		$CI->output->set_output($new_buffer);
		$CI->output->_display();
	}
?>