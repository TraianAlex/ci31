<?php

class Film_model extends CI_Model{

	public function search($limit, $offset){

		$q = $this->db->select('film_id, title, release_year, length, replacement_cost, rating')
			->from('film')->limit($limit, $offset);
		$ret['rows'] = $q->get()->result();

		$q = $this->db->select('COUNT(*) as count', FALSE)->from('film');//false disable backtich. when use func as field have to put false
		$tmp = $q->get()->result();

		$ret['num_rows'] = $tmp[0]->count;
		return $ret;
	}
}