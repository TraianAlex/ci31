<?php

class Film_model3 extends CI_Model{

	public function search($query_array, $limit, $offset, $sort_by, $sort_order){

		$sort_order = ($sort_order == 'desc') ? 'desc' : 'asc';
		$sort_columns = ['film_id', 'title', 'release_year', 'length', 'replacement_cost', 'rating', 'name'];
		$sort_by = (in_array($sort_by, $sort_columns)) ? $sort_by : 'title';
		
		$q = $this->db->select('film.film_id, film.title, film.release_year, film.length, film.replacement_cost, film.rating, category.name')
					  ->from('film')
					  ->join('film_category', 'film.film_id = film_category.film_id')
					  ->join('category', 'film_category.category_id = category.category_id', 'left')
					  ->limit($limit, $offset)
					  ->order_by($sort_by, $sort_order);
	    if(strlen($query_array['title'])){
	    	$q->like('title', $query_array['title']);
	    }
	    if(strlen($query_array['category'])){
	    	$q->where('name', $query_array['category']);
	    }
	    if(strlen($query_array['length'])){
	    	$operators = ['gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<'];
	    	$operator = $operators[$query_array['length_comparation']];
	    	$q->where("length $operator", $query_array['length']);
	    }
		$ret['rows'] = $q->get()->result();
/*----------------------------------------------------------------------------------------------*/
		$q = $this->db->select('COUNT(*) as count', FALSE)->from('film')
					  ->join('film_category', 'film.film_id = film_category.film_id')
					  ->join('category', 'film_category.category_id = category.category_id', 'left');//false disable backtich. when use func as field have to put false
		if(strlen($query_array['title'])){
	    	$q->like('title', $query_array['title']);
	    }
	    if(strlen($query_array['category'])){
	    	$q->where('name', $query_array['category']);
	    }
	    if(strlen($query_array['length'])){
	    	$operators = ['gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<'];
	    	$operator = $operators[$query_array['length_comparation']];
	    	$q->where("length $operator", $query_array['length']);
	    }
		$tmp = $q->get()->result();
/*---------------------------------------------------------------------------------------------------*/
		$ret['num_rows'] = $tmp[0]->count;
		return $ret;
	}

	public function category_options(){
		$rows = $this->db->select('name')->from('category')->get()->result();
		$category_options = ['' => ''];
		foreach($rows as $row){
			$category_options[$row->name] = $row->name;
		}
		return $category_options;
	}

	private function condition($query_array){
		if(strlen($query_array['title'])){
	    	$q->like('title', $query_array['title']);
	    }
	    if(strlen($query_array['category'])){
	    	$q->where('name', $query_array['category']);
	    }
	    if(strlen($query_array['length'])){
	    	$operators = ['gt' => '>', 'gte' => '>=', 'eq' => '=', 'lte' => '<=', 'lt' => '<'];
	    	$operator = $operators[$query_array['length_comparation']];
	    	$q->where("length $operator", $query_array['length']);
	    }
	    return $q;
	}
}