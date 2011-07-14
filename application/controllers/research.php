<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Research extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Research_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Research Editor');
    $this->smarty->assign('research', $this->Research_model->read());

    $this->smarty->assign('content', $this->parser->parse('research/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function add(){
    $messages = array();

    $research = $this->Research_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Checkbox('given', true);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Research_model->create($this->formclass->formData)){
        $messages['success'][] = 'The research has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the research.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('research', $builing);
    $this->smarty->assign('meta_title', 'Adding Research');

    $this->smarty->assign('content', $this->parser->parse('research/add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function edit($id){
    $messages = array();

    $research = $this->Research_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $research;
    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Checkbox('given', true);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Research_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The research has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the research.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('research', $builing);
    $this->smarty->assign('meta_title', 'Editing ' . $builing['name']);

    $this->smarty->assign('content', $this->parser->parse('research/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    $messages = array();
    $research = $this->Research_model->read_single($id);
    if ($this->Research_model->delete($id)){
      $messages['success'][] = 'The research has been deleted.';
    }else{
      $messages['error'][] = 'There was an error deleting the research.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $builing['name']);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('research', $builing);
    $this->smarty->assign('content', $this->parser->parse('research/delete.tpl', array(), true));
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
    $research = $this->Research_model->read_single($id);
    $resources = $this->Research_model->research_resources_list($id);

    $this->smarty->assign('research', $research);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('meta_title', 'Editing ' . $research['name']);

    $this->smarty->assign('content', $this->parser->parse('research/resources_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  private function resources_add($id){
    $research = $this->Research_model->read_single($id);
    $avail = $this->Research_model->resources_avail($id);
    
    if (!empty($avail)){
      $out = array();
      foreach ($avail as $res){
        $out[$res['name']] = $res['id'];
      }
    }else{
      $this->formclass->AddError('research', 'All avaliable research are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('resource_id', false, $out);
    $this->formclass->Integer('cost', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());    

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Research_model->resources_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The resource cost has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the resource cost.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('research', $research);
    $this->smarty->assign('meta_title', 'Adding ' . $research['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('research/resources_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }
  
  

  private function resources_edit($id, $resource_id){
    $research = $this->Research_model->read_single($id);
    $resources = $this->Research_model->research_resources_single($id, $resource_id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $resources;
    $this->formclass->Integer('cost', false, 0, 11);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Research_model->resources_update($id, $resource_id, $this->formclass->formData)){
        $messages['success'][] = 'The research has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the research.';
      }
    }

    $this->smarty->assign('research', $research);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Editing ' . $research['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('content', $this->parser->parse('research/resources_edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());      
  }



  private function resources_delete($id, $resource_id){
    $research = $this->Research_model->read_single($id);
    $resources = $this->Research_model->resources_single($resource_id);
    $messages = array();
    

    if ($this->Research_model->resources_delete($id, $resource_id)){
      $messages['success'][] = 'The resource cost has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the resource cost.';
    }
    
    $this->smarty->assign('meta_title', 'Deleting ' . $research['name'] . ' ' . $resources['name'] . 'resource cost');

    $this->smarty->assign('research', $research);
    $this->smarty->assign('resources', $resources);
    $this->smarty->assign('messages', $messages);
    
    $this->smarty->assign('content', $this->parser->parse('research/resources_delete.tpl', array(), true));
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
    $research = $this->Research_model->read_single($id);
    $prereq = $this->Research_model->research_preq_list($id);

    $this->smarty->assign('research', $research);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('meta_title', 'Prereq for  ' . $research['name']);

    $this->smarty->assign('content', $this->parser->parse('research/research_preq_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_add($id){
    $research = $this->Research_model->read_single($id);
    $avail = $this->Research_model->research_preq_avail($id);

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

    $this->formclass->Select('prereq', false, $out);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Research_model->research_preq_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The prerequisite has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the prerequisite.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('research', $research);
    $this->smarty->assign('meta_title', 'Adding ' . $research['name'] . ' prerequisite');

    $this->smarty->assign('content', $this->parser->parse('research/research_preq_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }


  private function research_preq_delete($id, $research_id){
    $research = $this->Research_model->read_single($id);
    $prereq = $this->Research_model->read_single($research_id);
    $messages = array();


    if ($this->Research_model->research_preq_delete($id, $research_id)){
      $messages['success'][] = 'The prerequisite has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the prerequisite.';
    }

    $this->smarty->assign('meta_title', 'Deleting ' . $research['name'] . ' prerequisite');

    $this->smarty->assign('research', $research);
    $this->smarty->assign('prereq', $prereq);
    $this->smarty->assign('messages', $messages);

    $this->smarty->assign('content', $this->parser->parse('research/research_preq_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

}

?>
