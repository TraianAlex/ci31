<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Magazine extends CI_Controller {

    public function index() {

        $this->load->library('table');
        $magazines = [];
        $this->load->model(['Issue', 'Publication']);
        $issues = $this->Issue->get();
        foreach ($issues as $issue) {
            $publication = new Publication();
            $publication->load($issue->publication_id);
            $magazines[] = [
                $publication->publication_name,
                $issue->issue_number,
                $issue->issue_date_publication,
                $issue->issue_cover ? 'Y' : 'N',
                anchor('magazine/view/'.$issue->issue_id, 'View').' | '.
                anchor('magazine/delete/'.$issue->issue_id, 'Delete')
            ];
        }
        $this->load->view('bootstrap/main', ['main' => 'magazines/magazines', 'magazines' => $magazines]);
    }

    public function add() {

        $config = [
            'upload_path' => 'upload',
            'allowed_types' => 'gif|jpg|png',
            'max_size' => 250,
            'max_width' => 1920,
            'max_heigh' => 1080,
        ];
        $this->load->library('upload', $config);

        $this->load->model('Publication');
        $publications = $this->Publication->get();
        $publication_form_options = [];
        foreach ($publications as $id => $publication) {
            $publication_form_options[$id] = $publication->publication_name;
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules([
           [
               'field' => 'publication_id',
               'label' => 'Publication',
               'rules' => 'required',
           ],
           [
               'field' => 'issue_number',
               'label' => 'Issue number',
               'rules' => 'required|is_numeric',
           ],
           [
               'field' => 'issue_date_publication',
               'label' => 'Publication date',
               'rules' => 'required|callback_date_validation',
           ],
        ]);
        $this->form_validation->set_error_delimiters('<div class="alert alert-error">', '</div>');

        $check_file_upload = FALSE;
        if (isset($_FILES['issue_cover']['error']) && ($_FILES['issue_cover']['error'] != 4)) {
            $check_file_upload = TRUE;
        }
        if (!$this->form_validation->run() || ($check_file_upload && !$this->upload->do_upload('issue_cover'))) {
            	$this->load->view('bootstrap/main', ['main' => 'magazines/magazine_form', 'publication_form_options'=> $publication_form_options]);
        }
        else {
            $this->load->model('Issue');
            $issue = new Issue();
            $issue->publication_id = $this->input->post('publication_id');
            $issue->issue_number = $this->input->post('issue_number');
            $issue->issue_date_publication = $this->input->post('issue_date_publication');
            $upload_data = $this->upload->data();
            if (isset($upload_data['file_name'])) {
                $issue->issue_cover = $upload_data['file_name'];
            }
            $issue->save();
            $this->load->view('bootstrap/main', ['main' => 'magazines/magazine_form_success', 'issue' => $issue]);
        }
    }
    /**
     * Date validation callback.
     * @param string $input
     * @return boolean
     */
    public function date_validation($input) {
        $test_date = explode('-', $input);
        if (!@checkdate($test_date[1], $test_date[2], $test_date[0])) {
            $this->form_validation->set_message('date_validation', 'The %s field must be in YYYY-MM-DD format.');
            return FALSE;
        }
        return TRUE;
    }

    public function view($issue_id){

    	$this->load->model(['Issue', 'Publication']);
    	$issue = new Issue();
    	$issue->load($issue_id);
    	if (!$issue->issue_id) {
    		show_404();
    	}
    	$publication = new Publication();
    	$publication->load($issue->publication_id);
        $this->load->view('bootstrap/main', ['main' => 'magazines/magazine', 'issue' => $issue, 'publication' => $publication]);
    }

    public function delete($issue_id){

    	$this->load->model('Issue');
    	$issue = new Issue();
    	$issue->load($issue_id);
    	if (!$issue->issue_id) {
    		show_404();
    	}
    	$issue->delete();
        $this->load->view('bootstrap/main', ['main' => 'magazines/magazine_deleted', 'issue_id' => $issue_id]);
    }

    public function create_magazine_test(){
        /*
        $this->load->model('Publication');
        $this->Publication->publication_name = 'Sandy Shore';
        $this->Publication->save();
        echo '<tt><pre>' . var_export($this->Publication, TRUE) . '</pre></tt>';
        
        $this->load->model('Issue');
        $issue = new Issue();
        $issue->publication_id = $this->Publication->publication_id;
        $issue->issue_number = 2;
        $issue->issue_date_publication = date('2013-02-01');
        $issue->save();
        echo '<tt><pre>' . var_export($issue, TRUE) . '</pre></tt>';

        $this->load->view('bootstrap/main', ['main' => 'magazines/magazines', 'issue' => $issue]);*/
    }

    public function read_magazine_test(){
        /*
        $data = [];
        $this->load->model('Publication');
        $publication = new Publication();
        $publication->load(1);
        $data['publication'] = $publication;
        
        $this->load->model('Issue');
        $issue = new Issue();
        $issue->load(1);
        
        $this->load->view('bootstrap/main', ['main' => 'magazines/magazines', 'issue' => $issue]);
        $this->load->view('bootstrap/main', ['main' => 'magazines/magazine', 'issue' => $issue]);*/
    }
}