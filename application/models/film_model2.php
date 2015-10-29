<?php

class Film_model2 extends CI_Model{

	public function search($limit, $offset, $sort_by, $sort_order){

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = ['film_id', 'title', 'release_year', 'length', 'replacement_cost', 'rating', 'name'];
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'title';
		
		$q = $this->db->select('film.film_id, film.title, film.release_year, film.length, film.replacement_cost, film.rating, category.name')
					  ->from('film')
					  ->join('film_category', 'film.film_id = film_category.film_id')
					  ->join('category', 'film_category.category_id = category.category_id', 'left')
					  ->limit($limit, $offset)
					  ->order_by($sort_by, $sort_order);
		$ret['rows'] = $q->get()->result();

		$q = $this->db->select('COUNT(*) as count', FALSE)->from('film');//false disable backtich. when use func as field have to put false
		$tmp = $q->get()->result();

		$ret['num_rows'] = $tmp[0]->count;
		return $ret;
	}
}