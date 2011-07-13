<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Resources extends CI_Controller{

  public function __construct() {
    parent::__construct();

    // Ideally you would autoload the parser
    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Resources_model');
  }

  public function index(){
    $this->smarty->assign('meta_title', 'Resource Editor');
    $this->smarty->assign('res', $this->Resources_model->read());

    $this->smarty->assign('content', $this->parser->parse('resources/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }

  public function edit($id){
    $messages = array();
    
    $resource = $this->Resources_model->read_single($id);

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $resource;
    $this->formclass->Text('name', false, 3, 255);
    $this->formclass->Integer('hp', false, 0, 11);
    $this->formclass->Integer('attack', false, 0, 11);
    $this->formclass->Checkbox('creatable', true);
    $this->formclass->Integer('turns', false, 0, 11);
    $this->formclass->Float('interest', false);
    $this->formclass->Checkbox('req_storage', true);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Resources_model->update($id, $this->formclass->formData)){
        $messages['success'][] = 'The resource has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the resource.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('res', $resource);
    $this->smarty->assign('meta_title', 'Editing ' . $resource['name']);

    $this->smarty->assign('content', $this->parser->parse('resources/edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
  }



  public function delete($id){
    // disabled
  }



  public function conversion($id, $action='list', $conversion_id=false){
  
    switch ($action){
      case 'add':  $this->conversion_add($id); break;
      case 'edit': $this->conversion_edit($id, $conversion_id); break;
      case 'delete': $this->conversion_delete($id, $conversion_id); break;
      case 'list':
      default: $this->conversion_list($id); break;
    }
    
  }



  private function conversion_list($id){
    $resource = $this->Resources_model->read_single($id); 
    $conversion = $this->Resources_model->conversion_list($id);  

    $this->smarty->assign('resource', $resource);
    $this->smarty->assign('conversion', $conversion);
    $this->smarty->assign('meta_title', 'Editing ' . $resource['name']);

    $this->smarty->assign('content', $this->parser->parse('resources/conversion_list.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());  
  }
  
  

  private function conversion_add($id){
    $resource = $this->Resources_model->read_single($id);
    $avail = $this->Resources_model->conversion_avail($id);
    
    if (!empty($avail)){
      $out = array();
      foreach ($avail as $res){
        $out[$res['name']] = $res['id'];
      }
    }else{
      $this->formclass->AddError('resource', 'All avaliable resources are already being used.');
    }

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->Select('cost_resource', false, $out);
    $this->formclass->Integer('qty', false, 0, 11);
    $this->formclass->Float('refund', false);
    
    $this->smarty->assign('form', $this->formclass->DrawForm());    
    
    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Resources_model->conversion_create($id, $this->formclass->formData)){
        $messages['success'][] = 'The conversion cost has been added.';
      }else{
        $messages['error'][] = 'There was an error adding the conversion cost.';
      }
    }

    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('resource', $resource);
    $this->smarty->assign('meta_title', 'Adding ' . $resource['name'] . ' ' . $conversion['name'] . 'conversion cost');

    $this->smarty->assign('content', $this->parser->parse('resources/conversion_add.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());  
  }
  
  

  private function conversion_edit($id, $conversion_id){    
    $resource = $this->Resources_model->read_single($id); 
    $conversion = $this->Resources_model->conversion_single($conversion_id);  

    if ($this->input->post()){
      $this->formclass->POST = $this->input->post();
    }

    $this->formclass->loadData = $conversion;
    $this->formclass->Integer('qty', false, 0, 11);
    $this->formclass->Float('refund', false);

    $this->smarty->assign('form', $this->formclass->DrawForm());

    if ($this->formclass->hasErrors){
      if ($this->input->post()){
        $this->smarty->assign('errors', $this->formclass->DisplayErrors());
      }
    }else{
      if ($this->Resources_model->conversion_update($id, $conversion_id, $this->formclass->formData)){
        $messages['success'][] = 'The resource has been updated.';
      }else{
        $messages['error'][] = 'There was an error updating the resource.';
      }
    }

    $this->smarty->assign('resource', $resource);
    $this->smarty->assign('conversion', $conversion);
    $this->smarty->assign('messages', $messages);
    $this->smarty->assign('meta_title', 'Editing ' . $resource['name'] . ' ' . $conversion['name'] . 'conversion cost');

    $this->smarty->assign('content', $this->parser->parse('resources/conversion_edit.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());      
  }


  
  private function conversion_delete($id, $conversion_id){
    $resource = $this->Resources_model->read_single($id); 
    $conversion = $this->Resources_model->conversion_single($conversion_id); 
    $messages = array();
    
    
    if ($this->Resources_model->conversion_delete($id, $conversion_id)){
      $messages['success'][] = 'The conversion cost has been deleted.';
    }else{
      $messages['success'][] = 'There was a problem deleting the conversion cost.';
    }
    
    $this->smarty->assign('meta_title', 'Deleting ' . $resource['name'] . ' ' . $conversion['name'] . 'conversion cost');

    $this->smarty->assign('resource', $resource);
    $this->smarty->assign('conversion', $conversion);
    $this->smarty->assign('messages', $messages);
    
    $this->smarty->assign('content', $this->parser->parse('resources/conversion_delete.tpl', array(), true));
    $this->parser->parse('layout.tpl', array()); 
  }

}

?>
