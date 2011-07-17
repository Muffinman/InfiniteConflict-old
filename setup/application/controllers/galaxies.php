<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Galaxies extends CI_Controller {

  public function __construct(){
    parent::__construct();
    // Ideally you would autoload the parser

    $this->load->library('parser');
    $this->load->library('formclass');
    $this->load->model('Galaxies_model');
  }


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
    $this->smarty->assign('meta_title', 'DG Clone #23822');

    $q = "TRUNCATE TABLE galaxy";
    $this->db->query($q);

    $q = "TRUNCATE TABLE system";
    $this->db->query($q);

    $q = "TRUNCATE TABLE planet";
    $this->db->query($q);

    $q = "SELECT * FROM config";
    $query = $this->db->query($q);
    $config = array();
    if ($query->num_rows() > 0){
      $result = $query->result_array();
      foreach($result as $row){
        $config[$row['key']] = $row['val'];
      }
    }

    for ($i=0; $i<=$config['gals']; $i++){
      $gal = array();
      $gal['home'] = $i % 2 ? 0 : 1;

      if ($gal['home'] == 1){
        $gal['rows'] = $config['home_gal_rows'];
        $gal['cols'] = $config['home_gal_cols'];
      }else{
        $gal['rows'] = $config['free_gal_rows'];
        $gal['cols'] = $config['free_gal_cols'];
      }
      do{
        $gal['type'] = rand(1, $config['gal_types']);
      } while ($gal['type'] == $prev);
      $prev = $gal['type'];

      # Insert galaxy
      $q = $this->db->insert_string('galaxy', $gal);
      if ($this->db->query($q)){
        $gal['id'] = $this->db->insert_id();

        for ($j=1; $j<=$gal['rows']; $j++){
          for ($k=1; $k<=$gal['cols']; $k++){
            $sys = array();
            $sys['galaxy_id'] = $gal['id'];
            if ($gal['home'] == 1){
              $sys['rows'] = $config['home_sys_rows'];
              $sys['cols'] = $config['home_sys_cols'];
            }else{
              $sys['rows'] = $config['free_sys_rows'];
              $sys['cols'] = $config['free_sys_cols'];
            }

            do{
              $sys['type'] = rand(1, $config['sys_types']);
            } while ($sys['type'] == $prev2);
            $prev2 = $sys['type'];

            # Insert system
            $q = $this->db->insert_string('system', $sys);
            if ($this->db->query($q)){

              $sys['id'] = $this->db->insert_id();

              for ($l=1; $l<=$sys['rows']; $l++){
                for ($m=1; $m<=$sys['cols']; $m++){
                  $planet = array();

                  $planet['galaxy_id'] = $gal['id'];
                  $planet['system_id'] = $sys['id'];
                  if ($l <= $config['home_sys_hp_rows'] && $gal['home'] == 1){
                    $planet['home'] = 1;
                  }else{
                    $planet['home'] = 0;
                  }

                  $planet['type'] = rand(1, $config['planet_types']);

                  $q = $this->db->insert_string('planet', $planet);
                  if ($this->db->query($q)){
                    $planet['id'] = $this->db->insert_id();
                  }


                }
              }

            }


          }
        }

      }

    }

    $this->smarty->assign('content', $this->parser->parse('galaxies/index.tpl', array(), true));
    $this->parser->parse('layout.tpl', array());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
