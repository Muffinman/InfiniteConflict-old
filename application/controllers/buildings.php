<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Buildings extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Buildings_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Building Editor');
    $this->smarty->assign('buildings', $this->Buildings_model->read());

    $this->smarty->assign('content', $this->parser->parse('buildings/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function add(){
    $messages = array();

    $building = $this->Buildings_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Integer('max', false, 0, 11);
    $this->formclass->Integer('demolish', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Buildings_model->create($this->formclass->formData)){
        $messages['success'][] = 'The building has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the building.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $builing);
    $this->smarty->assign('meta_title', 'Adding Building');

    $this->smarty->assign('content', $this->parser->parse('buildings/add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function edit($id){
    $messages = array();

    $building = $this->Buildings_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $building;
    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Integer('max', false, 0, 11);
    $this->formclass->Integer('demolish', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Buildings_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The building has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the building.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $builing);
    $this->smarty->assign('meta_title', 'Editing ' . $builing['name']);

    $this->smarty->assign('content', $this->parser->parse('buildings/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    $messages = array();
    $building = $this->Buildings_model->read_single($id);
    if ($this->Buildings_model->delete($id)){
      $messages['success'][] = 'The building has been deleted.';
    }else{
      $messages['error'][] = 'There was an error deleting the building.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $builing['name']);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $builing);
    $this->smarty->assign('content', $this->parser->parse('buildings/delete.tpl', array(), true));
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
    $building = $this->Buildings_model->read_single($id);
    $resources = $this->Buildings_model->building_resources_list($id);

    $this->smarty->assign('building', $building);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('meta_title', 'Editing ' . $building['name']);

    $this->smarty->assign('content', $this->parser->parse('buildings/resources_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  private function resources_add($id){
    $building = $this->Buildings_model->read_single($id);
    $avail = $this->Buildings_model->resources_avail($id);
    
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

    $this->formclass->Select('resource_id', false, $out);
    $this->formclass->Integer('cost', false, 0, 11);
    $this->formclass->Integer('output', false, 0, 11);
    $this->formclass->Integer('stores', false, 0, 11);
    $this->formclass->Float('interest', false);
    $this->formclass->Float('abundance', false);
    $this->formclass->Float('refund', false);

    $this->smarty->assign('form', $this->formclass->DrawForm());    

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Buildings_model->resources_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The resource cost has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the resource cost.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $building);
    $this->smarty->assign('meta_title', 'Adding ' . $building['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('buildings/resources_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }
  
  

  private function resources_edit($id, $resource_id){
    $building = $this->Buildings_model->read_single($id);
    $resources = $this->Buildings_model->building_resources_single($id, $resource_id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $resources;
    $this->formclass->Integer('cost', false, 0, 11);
    $this->formclass->Integer('output', false, 0, 11);
    $this->formclass->Integer('stores', false, 0, 11);
    $this->formclass->Float('interest', false);
    $this->formclass->Float('abundance', false);
    $this->formclass->Float('refund', false);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Buildings_model->resources_update($id, $resource_id, $this->formclass->formData)){
        $messages['success'][] = 'The building has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the building.';
      }
    }

    $this->smarty->assign('building', $building);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Editing ' . $building['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('buildings/resources_edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());      
  }



  private function resources_delete($id, $resource_id){
    $building = $this->Buildings_model->read_single($id);
    $resources = $this->Buildings_model->resources_single($resource_id);
    $messages = array();
    

    if ($this->Buildings_model->resources_delete($id, $resource_id)){
      $messages['success'][] = 'The resource cost has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the resource cost.';
    }
    
    $this->smarty->assign('meta_title', 'Deleting ' . $building['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('building', $building);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    
    $this->smarty->assign('content', $this->parser->parse('buildings/resources_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  public function buildings_preq($id, $action='list', $building_id=false){
    switch ($action){
      case 'add':  $this->buildings_preq_add($id); break;
      case 'delete': $this->buildings_preq_delete($id, $building_id); break;
      case 'list':
      default: $this->buildings_preq_list($id); break;
    }
  }


  private function buildings_preq_list($id){
    $building = $this->Buildings_model->read_single($id);
    $prereq = $this->Buildings_model->buildings_preq_list($id);

    $this->smarty->assign('building', $building);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('meta_title', 'Prereq for  ' . $building['name']);

    $this->smarty->assign('content', $this->parser->parse('buildings/buildings_preq_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function buildings_preq_add($id){
    $building = $this->Buildings_model->read_single($id);
    $avail = $this->Buildings_model->buildings_preq_avail($id);

    if (!empty($avail)){
      $out = array();
      foreach ($avail as $b){
        $out[$b['name']] = $b['id'];
      }
    }else{
      $this->formclass->AddError('building', 'All avaliable buildings are already being used.');
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
      if ($this->Buildings_model->buildings_preq_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The prerequisite has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the prerequisite.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $building);
    $this->smarty->assign('meta_title', 'Adding ' . $building['name'] . ' prerequisite');

    $this->smarty->assign('content', $this->parser->parse('buildings/buildings_preq_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function buildings_preq_delete($id, $building_id){
    $building = $this->Buildings_model->read_single($id);
    $prereq = $this->Buildings_model->read_single($building_id);
    $messages = array();


    if ($this->Buildings_model->buildings_preq_delete($id, $building_id)){
      $messages['success'][] = 'The prerequisite has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the prerequisite.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $building['name'] . ' prerequisite');

    $this->smarty->assign('building', $building);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('messages', $messages);

    $this->smarty->assign('content', $this->parser->parse('buildings/buildings_preq_delete.tpl', array(), true));
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
    $building = $this->Buildings_model->read_single($id);
    $prereq = $this->Buildings_model->research_preq_list($id);

    $this->smarty->assign('building', $building);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('meta_title', 'Prereq for  ' . $building['name']);

    $this->smarty->assign('content', $this->parser->parse('buildings/research_preq_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_add($id){
    $building = $this->Buildings_model->read_single($id);
    $avail = $this->Buildings_model->research_preq_avail($id);

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
      if ($this->Buildings_model->research_preq_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The prerequisite has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the prerequisite.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('building', $building);
    $this->smarty->assign('meta_title', 'Adding ' . $building['name'] . ' prerequisite');

    $this->smarty->assign('content', $this->parser->parse('buildings/research_preq_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_delete($id, $research_id){
    $building = $this->Buildings_model->read_single($id);
    $prereq = $this->Buildings_model->read_single($research_id);
    $messages = array();


    if ($this->Buildings_model->research_preq_delete($id, $research_id)){
      $messages['success'][] = 'The prerequisite has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the prerequisite.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $building['name'] . ' prerequisite');

    $this->smarty->assign('building', $building);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('messages', $messages);

    $this->smarty->assign('content', $this->parser->parse('buildings/research_preq_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

}

?>
