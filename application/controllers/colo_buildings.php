<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Colo_buildings extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Colo_buildings_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Colo Building Editor');
    $this->smarty->assign('buildings', $this->Colo_buildings_model->read());

    $this->smarty->assign('content', $this->parser->parse('colo_buildings/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  public function add(){
    $messages = array();
    $avail = $this->Colo_buildings_model->buildings_avail();

    if (!empty($avail)){
      $out = array();
      foreach ($avail as $res){
        $out[$res['name']] = $res['id'];
      }
    }else{
      $this->formclass->AddError('building', 'All avaliable buildings are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('building_id', false, $out);
    $this->formclass->Integer('qty', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Colo_buildings_model->create($this->formclass->formData)){
        $messages['success'][] = 'The building has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the building.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Adding coloing building ');

    $this->smarty->assign('content', $this->parser->parse('colo_buildings/add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());

  }

  public function edit($id){
    $messages = array();
    $building = $this->Colo_buildings_model->read_single($id);


    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $building;
    $this->formclass->Integer('stored', false, 0, 11);
    $this->formclass->Float('abundance', false);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Colo_buildings_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The building has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the building.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $building);
    $this->smarty->assign('meta_title', 'Editing ' . $building['name']);

    $this->smarty->assign('content', $this->parser->parse('colo_buildings/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    $messages = array();
    if ($building = $this->Colo_buildings_model->delete($id)){
      $messages['success'][] = 'The building has been deleted.';
    }else{
      $messages['error'][] = 'There was an error deleting the building.';
    }
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Deleting colo building');

    $this->smarty->assign('content', $this->parser->parse('colo_buildings/delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

}

?>
