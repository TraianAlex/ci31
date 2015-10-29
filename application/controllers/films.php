<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Films extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function display($offset=0) {

    	$limit = 20;
    	$this->load->model('film_model');
    	$results = $this->film_model->search($limit, $offset);
    	$data['films'] = $results['rows'];
    	$data['num_results'] = $results['num_rows'];

    	$this->load->library('pagination');
    	$config = []; 
    	$config['base_url'] = site_url('films/display');
    	$config['total_rows'] = $data['num_results'];
    	$config['per_page'] = $limit;
    	$config['uri_segment'] = 3;
    	$config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>'; 
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();

        $data['main'] = 'film/film';
        $this->load->view('templates/main', $data);
    }
}
        