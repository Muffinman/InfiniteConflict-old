<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colo_resources extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Colo_resources_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Resource Editor');
    $this->smarty->assign('res', $this->Colo_resources_model->read());

    $this->smarty->assign('content', $this->parser->parse('colo_resources/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  public function add(){
    $messages = array();
    $avail = $this->Colo_resources_model->resources_avail();

    if (!empty($avail)){
      $out = array();
      foreach ($avail as $res){
        $out[$res['name']] = $res['id'];
      }
    }else{
      $this->formclass->AddError('resources', 'All avaliable resources are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('resource_id', false, $out);
    $this->formclass->Integer('stored', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Colo_resources_model->create($this->formclass->formData)){
        $messages['success'][] = 'The resource has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the resource.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Adding colo resource');

    $this->smarty->assign('content', $this->parser->parse('colo_resources/add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());

  }

  public function edit($id){
    $messages = array();
    $resource = $this->Colo_resources_model->read_single($id);


    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $resource;
    $this->formclass->Integer('stored', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Colo_resources_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The resource has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the resource.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('res', $resource);
    $this->smarty->assign('meta_title', 'Editing ' . $resource['name']);

    $this->smarty->assign('content', $this->parser->parse('colo_resources/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    $messages = array();
    if ($resource = $this->Colo_resources_model->delete($id)){
      $messages['success'][] = 'The resource has been deleted.';
    }else{
      $messages['error'][] = 'There was an error deleting the resource.';
    }
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Deleting colo resource');

    $this->smarty->assign('content', $this->parser->parse('colo_resources/delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

}

?>
