<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Films3 extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('my_input');
        $this->output->enable_profiler(TRUE);
    }

    public function display($query_id = 0, $sort_by = 'title', $sort_order = 'asc', $offset = 0) {

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

        $this->my_input->load_query($query_id);
        $query_array = [
            'title' => $this->input->get('title'),
            'category' => $this->input->get('category'),
            'length_comparation' => $this->input->get('length_comparation'),
            'length' => $this->input->get('length')
        ];
        $data['query_id'] = $query_id;

    	$this->load->model('film_model3');
    	$results = $this->film_model3->search($query_array, $limit, $offset, $sort_by, $sort_order);
    	$data['films'] = $results['rows'];
    	$data['num_results'] = $results['num_rows'];

    	$this->load->library('pagination');
    	$config = []; 
    	$config['base_url'] = site_url("films3/display/$query_id/$sort_by/$sort_order");
    	$config['total_rows'] = $data['num_results'];
    	$config['per_page'] = $limit;
    	$config['uri_segment'] = 6;
    	$config['full_tag_open'] = '<div id="pagination">';
        $config['full_tag_close'] = '</div>'; 
    	$this->pagination->initialize($config);
    	$data['pagination'] = $this->pagination->create_links();

        $data['sort_by'] = $sort_by;
        $data['sort_order'] = $sort_order;

        $data['category_options'] = $this->film_model3->category_options();
        $data['main'] = 'film/film3';
        $this->load->view('templates/main', $data);
    }

    public function search(){
        $query_array = [
            'title' => $this->input->post('title'),
            'category' => $this->input->post('category'),
            'length_comparation' => $this->input->post('length_comparation'),
            'length' => $this->input->post('length')
        ];
        $query_id = $this->my_input->save_query($query_array);
        redirect("films3/display/$query_id");
    }
}
        