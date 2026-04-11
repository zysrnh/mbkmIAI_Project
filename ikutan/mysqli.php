<?php

require_once("config.php");

class sql_db {
	var $db_connect_id;
	var $query_result;
	var $row = array();
	var $rowset = array();
	var $num_queries = 0;
	var $total_time_db = 0;
	var $time_query = "";
	
	function sql_db($sqlserver, $sqluser, $sqlpassword, $database, $persistency = true) {
	
	
	$this->db_connect_id = mysqli_connect($sqlserver, $sqluser, $sqlpassword, $database);

	/* check connection */ 
	if (!$this->db_connect_id) {
		return false;
		//printf("Connect failed: %s\n", mysqli_connect_error());
		//exit();
	} else {
	
		return $this->db_connect_id;
	}

	/*
		$this->db_connect_id = ($persistency) ? @mysqli_connect($sqlserver, $sqluser, $sqlpassword) : @mysqli_connect($sqlserver, $sqluser, $sqlpassword);
		if ($this->db_connect_id) {
			if ($database != "" && !@mysqli_select_db($database)) {
				@mysqli_close($this->db_connect_id);
				$this->db_connect_id = false;
			}
			return $this->db_connect_id;
		} else {
			return false;
		}
	*/	
	}

	function sql_close() {
		if ($this->db_connect_id) {
			if ($this->query_result) @mysqli_free_result($this->query_result);
			$result = @mysqli_close($this->db_connect_id);
			return $result;
		} else {
			return false;
		}
	}

	function sql_query($query = "", $transaction = false) {
		if ($query != "") {
			$this->query_result = @mysqli_query($this->db_connect_id, $query );
			return $this->query_result;
		}
		/*
		if ($this->query_result) {
			$this->num_queries += 1;
			//unset($this->row[$this->query_result]);
			//unset($this->rowset[$this->query_result]);
			return $this->query_result;
		} else {
			//return ($transaction == END_TRANSACTION) ? true : false;
		}
		*/
	}

	function sql_numrows($query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			$result = @mysqli_num_rows($query_id);
			return $result;
		} else {
			return false;
		}
	}

	function sql_affectedrows() {
		if ($this->db_connect_id) {
			$result = @mysqli_affected_rows($this->db_connect_id);
			return $result;
		} else {
			return false;
		}
	}

	function sql_numfields($query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			$result = @mysqli_num_fields($query_id);
			return $result;
		} else {
			return false;
		}
	}

	function sql_fieldname($offset, $query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			$result = @mysqli_field_name($query_id, $offset);
			return $result;
		} else {
			return false;
		}
	}

	function sql_fieldtype($offset, $query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		if($query_id) {
			$result = @mysqli_field_type($query_id, $offset);
			return $result;
		} else {
			return false;
		}
	}

	function sql_fetchrow($query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		//$query_id = $this->query_result;
		if($query_id) {
			 //$q_id=$query_id[0];
			 $this->row = @mysqli_fetch_array($query_id, MYSQLI_BOTH);
			 return $this->row;
		} else {
			 return false;
		}
	}

	function sql_fetchrowset($query_id) {

		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			//unset($this->rowset[$query_id]);
			//unset($this->row[$query_id]);
			while ($this->rowset[$query_id] = @mysqli_fetch_array($query_id, MYSQLI_BOTH)) {
				$result[] = $this->rowset[$query_id];
			}
			return $result;
		} else {
			return false;
		}
	}

	function sql_fetchfield($field, $rownum = -1, $query_id ) {
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			if ($rownum > -1) {
				$result = @mysqli_result($query_id, $rownum, $field);
			} else {
				if (empty($this->row[$query_id]) && empty($this->rowset[$query_id])) {
					if ($this->sql_fetchrow()) {
						$result = $this->row[$query_id][$field];
					}
				} else {
					if ($this->rowset[$query_id]) {
						$result = $this->rowset[$query_id][0][$field];
					} else if ($this->row[$query_id]) {
						$result = $this->row[$query_id][$field];
					}
				}
			}
			return $result;
		} else {
			return false;
		}
	}

	function sql_rowseek($rownum, $query_id) {
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			$result = @mysqli_data_seek($query_id, $rownum);
			return $result;
		} else {
			return false;
		}
	}

	function sql_nextid() {
		if ($this->db_connect_id) {
			$result = @mysqli_insert_id($this->db_connect_id);
			return $result;
		} else {
			return false;
		}
	}

	function sql_freeresult($query_id){
		//if (!$query_id) $query_id = $this->query_result;
		if ($query_id) {
			//unset($this->row[$query_id]);
			//unset($this->rowset[$query_id]);
			@mysqli_free_result($query_id);
			return true;
		} else {
			return false;
		}
	}

	function sql_error($query_id) {
		$result["message"] = @mysqli_error($this->db_connect_id);
		$result["code"] = @mysqli_errno($this->db_connect_id);
		return $result;
	}
}

$koneksi_db = new sql_db($mysql_host, $mysql_user, $mysql_password, $mysql_database, false);

if (!$koneksi_db->db_connect_id) {	
die("<br /><br /><center><img src=\"images/under_construction.gif\"><br /><br />Silahkan lakukan instalsi di: yourdomain.com/installer.php<br /><br /></center>");
}
?>