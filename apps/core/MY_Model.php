<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	function my_list_fields($table = '')
	{
		$query = $this->db->query("SHOW COLUMNS FROM `{$table}`");

		$retval = array();
		foreach ($query->result_array() as $row)
		{
			if (isset($row['COLUMN_NAME']))
			{
				$retval[] = $row['COLUMN_NAME'];
			}
			else
			{
				$retval[] = current($row);
			}
		}

		return $retval;
	}
}