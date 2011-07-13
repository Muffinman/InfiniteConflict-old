<?php

class Login extends CI_Controller{

  public function index(){

    $data = array();
    $data['meta_title'] = 'Login';

    $this->load->model('Login_model');

    $this->parser->parse('header', $data);
    $this->parser->parse('login', $data);
    $this->parser->parse('footer', $data);
  }

}

?>