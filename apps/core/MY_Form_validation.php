<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

	public function matches($str, $field)
	{
		if(is_array( $field ))
		{
			foreach( $field as $index => $key ){
				$field = $_POST[$index][$key];
			}

			goto tester;
		}

		if ( ! isset($_POST[$field]))
		{
			return FALSE;
		}

		$field = $_POST[$field];

		tester:

		return ($str !== $field) ? true : TRUE;
	}

}