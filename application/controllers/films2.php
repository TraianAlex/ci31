<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Films2 extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function display($sort_by = 'title', $sort_order = 'asc', $offset = 0) {

    	$limit = 20;
        $data['fields'] = [
            'film_id' => 'ID',
            'title' => 'Title',
            'release_year' => 'Year',
            'length' => 'Length',
            'replacement_cost' => 'Price',
            'rating' => 'Rating',
            'name' => 'Category'
        ];

    	$this->load->model('film_model2');
    	$results = $this->film_model2->search($limit, $offset, $sort_by, $sort_order);
    	$data['films'] = $results['rows'];
    	$data['num_results'] = $results['num_rows'];

    	$this->load->library('pagination');
    	$config = []; 
    	$config['base_url'] = site_url("films2/display/$sort_by/$sort_order");
    	$config['total_rows'] = $data['num_results'];
    	$config['per_page'] = $limit;
    	$config['uri_segment'] = 5;
    	$config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>'; 
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['main'] = 'film/film2';
        $this->load->view('templates/main', $data);
    }
}