<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ships extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Ships_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Ship Editor');
    $this->smarty->assign('ships', $this->Ships_model->read());

    $this->smarty->assign('content', $this->parser->parse('ships/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function add(){
    $messages = array();

    $ship = $this->Ships_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Integer('max', false, 0, 11);
    $this->formclass->Integer('drive', false, 0, 11);
    $this->formclass->Checkbox('can_colonise', true);
    $this->formclass->Checkbox('can_invade', true);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->create($this->formclass->formData)){
        $messages['success'][] = 'The ship has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the ship.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('meta_title', 'Adding Ship');

    $this->smarty->assign('content', $this->parser->parse('ships/add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function edit($id){
    $messages = array();

    $ship = $this->Ships_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $ship;
    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Integer('max', false, 0, 11);
    $this->formclass->Integer('drive', false, 0, 11);
    $this->formclass->Checkbox('can_colonise', true);
    $this->formclass->Checkbox('can_invade', true);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The ship has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the ship.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('meta_title', 'Editing ' . $ship['name']);

    $this->smarty->assign('content', $this->parser->parse('ships/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    $messages = array();
    $ship = $this->Ships_model->read_single($id);
    if ($this->Ships_model->delete($id)){
      $messages['success'][] = 'The ship has been deleted.';
    }else{
      $messages['error'][] = 'There was an error deleting the ship.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $ship['name']);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('content', $this->parser->parse('ships/delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function resources($id, $action='list', $resource_id=false){

    switch ($action){
      case 'add':  $this->resources_add($id); break;
      case 'edit': $this->resources_edit($id, $resource_id); break;
      case 'delete': $this->resources_delete($id, $resource_id); break;
      case 'list':
      default: $this->resources_list($id); break;
    }

  }



  private function resources_list($id){
    $ship = $this->Ships_model->read_single($id);
    $resources = $this->Ships_model->ship_resources_list($id);

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('meta_title', 'Editing ' . $ship['name']);

    $this->smarty->assign('content', $this->parser->parse('ships/resources_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  private function resources_add($id){
    $ship = $this->Ships_model->read_single($id);
    $avail = $this->Ships_model->resources_avail($id);
    
    if (!empty($avail)){
      $out = array();
      foreach ($avail as $res){
        $out[$res['name']] = $res['id'];
      }
    }else{
      $this->formclass->AddError('ship', 'All avaliable ships are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('resource_id', false, $out);
    $this->formclass->Integer('cost', false, 0, 11);
    $this->formclass->Float('refund', false);
    $this->formclass->Integer('storage', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());    

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->resources_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The resource cost has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the resource cost.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('meta_title', 'Adding ' . $ship['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('ships/resources_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }
  
  

  private function resources_edit($id, $resource_id){
    $ship = $this->Ships_model->read_single($id);
    $resources = $this->Ships_model->ship_resources_single($id, $resource_id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $resources;
    $this->formclass->Integer('cost', false, 0, 11);
    $this->formclass->Float('refund', false);
    $this->formclass->Integer('storage', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->resources_update($id, $resource_id, $this->formclass->formData)){
        $messages['success'][] = 'The ship has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the ship.';
      }
    }

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Editing ' . $ship['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('ships/resources_edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());      
  }



  private function resources_delete($id, $resource_id){
    $ship = $this->Ships_model->read_single($id);
    $resources = $this->Ships_model->resources_single($resource_id);
    $messages = array();
    

    if ($this->Ships_model->resources_delete($id, $resource_id)){
      $messages['success'][] = 'The resource cost has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the resource cost.';
    }
    
    $this->smarty->assign('meta_title', 'Deleting ' . $ship['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    
    $this->smarty->assign('content', $this->parser->parse('ships/resources_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function building_preq($id, $action='list', $buildings_id=false){
    switch ($action){
      case 'add':  $this->building_preq_add($id); break;
      case 'delete': $this->building_preq_delete($id, $buildings_id); break;
      case 'list':
      default: $this->building_preq_list($id); break;
    }
  }


  private function building_preq_list($id){
    $ship = $this->Ships_model->read_single($id);
    $prereq = $this->Ships_model->ships_preq_list($id);

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('meta_title', 'Prereq for  ' . $ship['name']);

    $this->smarty->assign('content', $this->parser->parse('ships/buildings_preq_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function building_preq_add($id){
    $ship = $this->Ships_model->read_single($id);
    $avail = $this->Ships_model->ships_preq_avail($id);

    if (!empty($avail)){
      $out = array();
      foreach ($avail as $b){
        $out[$b['name']] = $b['id'];
      }
    }else{
      $this->formclass->AddError('ship', 'All avaliable buildings are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('prereq', false, $out);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->ships_preq_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The prerequisite has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the prerequisite.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('meta_title', 'Adding ' . $ship['name'] . ' prerequisite');

    $this->smarty->assign('content', $this->parser->parse('ships/buildings_preq_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function building_preq_delete($id, $building_id){
    $ship = $this->Ships_model->read_single($id);
    $prereq = $this->Ships_model->building_single($building_id);
    $messages = array();


    if ($this->Ships_model->ships_preq_delete($id, $building_id)){
      $messages['success'][] = 'The prerequisite has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the prerequisite.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $ship['name'] . ' prerequisite');

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('messages', $messages);

    $this->smarty->assign('content', $this->parser->parse('ships/buildings_preq_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  public function research_preq($id, $action='list', $research_id=false){
    switch ($action){
      case 'add':  $this->research_preq_add($id); break;
      case 'delete': $this->research_preq_delete($id, $research_id); break;
      case 'list':
      default: $this->research_preq_list($id); break;
    }
  }


  private function research_preq_list($id){
    $ship = $this->Ships_model->read_single($id);
    $prereq = $this->Ships_model->research_preq_list($id);

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('meta_title', 'Prereq for  ' . $ship['name']);

    $this->smarty->assign('content', $this->parser->parse('ships/research_preq_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_add($id){
    $ship = $this->Ships_model->read_single($id);
    $avail = $this->Ships_model->research_preq_avail($id);

    if (!empty($avail)){
      $out = array();
      foreach ($avail as $b){
        $out[$b['name']] = $b['id'];
      }
    }else{
      $this->formclass->AddError('research', 'All avaliable research is already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('research_id', false, $out);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Ships_model->research_preq_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The prerequisite has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the prerequisite.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('meta_title', 'Adding ' . $ship['name'] . ' prerequisite');

    $this->smarty->assign('content', $this->parser->parse('ships/research_preq_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_delete($id, $research_id){
    $ship = $this->Ships_model->read_single($id);
    $prereq = $this->Ships_model->read_single($research_id);
    $messages = array();


    if ($this->Ships_model->research_preq_delete($id, $research_id)){
      $messages['success'][] = 'The prerequisite has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the prerequisite.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $ship['name'] . ' prerequisite');

    $this->smarty->assign('ship', $ship);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('messages', $messages);

    $this->smarty->assign('content', $this->parser->parse('ships/research_preq_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

}

?>
