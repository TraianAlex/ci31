<?php

function set_value($field, $default = '', $html_escape = TRUE){
		$CI =& get_instance();
		if(isset($_POST[$field])){
			$value = (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
				? $CI->form_validation->set_value($field, $default)
				: $CI->input->post($field, FALSE);
		}
		if(isset($_GET[$field])){
			$value = (isset($CI->form_validation) && is_object($CI->form_validation) && $CI->form_validation->has_rule($field))
				? $CI->form_validation->set_value($field, $default)
				: $CI->input->get($field, FALSE);
		}

		isset($value) OR $value = $default;
		return ($html_escape) ? html_escape($value) : $value;
	}