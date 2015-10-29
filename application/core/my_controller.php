<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public $data = array();
	public $view = TRUE;
	public $layout = TRUE;
	public $models = array();
	public $before_filters = array();
	public $after_filters = array();
/*
	autoload models by adding an array in a attr, models named shorter
	ex. public $models = array('user', 'post');
*/
    public function __construct() {
        parent::__construct();
		$this->load->helper('inflector');
		$model = strtolower(singular(get_class($this)));
		if (file_exists(APPPATH . 'models/' . $model . '_model.php')){
			$this->models[] = $model;
		}
		foreach ($this->models as $model){
			$this->load->model($model . '_model', $model);
		}
    }
/*
 default 'class/method' load in templates/class layout or templates/template
 $this->layout = 'tests/tests';//class/method load in class/class
 $this->view = 'templates/user_test';//templates/method load in templates/class
*/
	public function _remap($method, $parameters){

		if (method_exists($this, $method)){
			$this->_run_filters('before', $method, $parameters);
				call_user_func_array(array($this, $method), $parameters);
			$this->_run_filters('after', $method, $parameters);
		}else{
			show_404();
		}
		$view = strtolower(get_class($this)) . '/' . $method;
		$view = (is_string($this->view) && !empty($this->view)) ? $this->view : $view;
		if ($this->view !== FALSE){
			$this->data['yield'] = $this->load->view($view, $this->data, TRUE);

			if (is_string($this->layout) && !empty($this->layout)){
				$layout = $this->layout;
			}elseif (file_exists(APPPATH.'views/templates/'.strtolower(get_class($this)).'.php')){
				$layout = 'templates/' . strtolower(get_class($this));
			}else{
				$layout = 'templates/template';//layouts/application
			}

			if ($this->layout){
				$this->load->view($layout, $this->data);
			}else{
				echo $this->data['yield'];//load tests/user_test.php in templates/template ($yield)
			}
		}
	}
/*
	public $before_filters = array( 'authenticate_user', 'fetch_account');
	public $before_filters = array( 'authenticate_user' => array( 'only' => 'secure'),
									    'fetch_account' => array('except' => 'select_account'));
	public $before_filters = array( 'authenticate_user',
									 'fetch_account' => array('except' => 'select_account'));
*/
	protected function _run_filters($what, $action, $parameters){

		$what = $what . '_filters';
        foreach ($this->$what as $filter => $details) {
            if (is_string($details)) {
                $this->$details($action, $parameters);
            } elseif (is_array($details)) {
                if (in_array($action, @$details['only']) || !in_array($action, @$details['except'])){
                    $this->$filter($action, $parameters);
                }
            }
        }
    }

}
/*
    public function _remap($method, $parameters){
    	if (method_exists($this, $method)){
			call_user_func_array(array($this, $method), $parameters);
		}else{
			show_404();
		}
		$view = strtolower(get_class($this)) . '/' . $method;
		$view = (is_string($this->view) && !empty($this->view)) ? $this->view : $view;
		if ($this->view !== FALSE){
			//$this->load->view($view, $this->data);
			$this->data['yield'] = $this->load->view($view, $this->data, TRUE);
		}
		$this->load->view('templates/template', $this->data);//
	}
*/