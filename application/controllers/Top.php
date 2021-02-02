<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Top extends CI_Controller {


	function __construct() {
        parent::__construct();
        //helper
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->helper('myhtmlview');
        $this->load->helper('cookie');
        
        //library
		$this->load->library('session');
        //$this->load->library('csvimport');
        $this->load->library('pagination');

        //model
        //$this->load->model('Ipam');
        $this->load->model('Dictionary');
    }


	public function index()
	{       
        $data["host_name"]="";    //this is form in header
        $maxrow=2000;             //for save memory

        //============== search word==============================
        if( $_POST[ 'form' ] == on){
            // for form
            $search = ($this->input->post("search"))? $this->input->post("search") : "NIL";
            //$search = $this->input->post('search');
            //$search = $_POST['search'];
            //echo " 1 : "."$search" . "<br>";
        }else{
            // for pagenation
            $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
            //echo " 2 : "."$search" . "<br>";
        }

        //$search = $_POST['search'];
        $search = str_replace("　", " ", $search);  // for Japanese Space
        $search = trim($search);

        // url encode for japanese
        $search= urldecode($search);
        
        empty($search) ? $data["search"]="" : $data["search"]=$search;
        if($search == "NIL" ){ $data["search"]=""; }

        //$data['search'] = $search;
        //echo " 1 : "."$search" . "<br>";

        //============== dictionary ==============================
        if( $_POST[ 'form' ] == on){
            // for form
            //echo "form";
            if($this->input->post('pulldown')){
                $database=$_POST['pulldown'];
                set_cookie('pulldown', $database, 3600);
                //echo "post database=$database<br>";
                //$value=on;
            }
        }else{
            $database= get_cookie('pulldown');    
            //echo "post2 database=$database<br>";

            //Default Database
            if(empty($database)){
                $database=eijiro;
            }
        }


        /*
        if ($database == eijiro){
            $data['select_eijiro'] = 'selected';
        }else if($database == reijiro){
            $data['select_reijiro'] = 'selected';
        }
        */
        $data["select_$database"] = 'selected';
        
        
        //============== checkbox ==============================
        if( $_POST[ 'form' ] == on){
            // for form
            if($this->input->post('check01')){
                set_cookie('checkbox', 'on', 3600);
                //echo "post on<br>";
                $value=on;
            }
            else{
                set_cookie('checkbox', 'off', 3600);
                //echo "post off<br>";
                $value=off;
            }
        }else{
            // for pagenation
            $value= get_cookie('checkbox');
        }

        if ( $value == on ){
           $data['check01checked'] = 'checked="checked"';
            //echo "kakunin" . $data['check01checked'] . "<br>";
            $check01="on";
        }

        //============== radio ==============================
        if( $_POST[ 'form' ] == on ){
            if( $_POST[ 'radio' ] == entry ){
                set_cookie('radio', 'entry', 3600);
                //echo "radio entry<br>";
                $radiovalue=entry;
            }
            else{
                set_cookie('radio', 'desc', 3600);
                //echo "radio desc<br>";
                $radiovalue=desc;
            }
        }else{
            //pagenation
            $radiovalue= get_cookie('radio');
        }

        if ( $radiovalue == "" ){
            $radiovalue=entry;
        }
        // echo "radio" . $radiovalue  . "<br>";

        //echo "value = " . $value. "<br>";
        if ( $radiovalue == entry ){
           $data['radio_entry'] = 'checked';
            //echo "kakunin" . $data['check01checked'] . "<br>";
        }else{
            $data['radio_desc'] = 'checked';
        }




        //============== pagenation ==============================
        //$config['base_url'] = site_url("search/$search");
        //$config['base_url'] = site_url("top/index/$search/$check01");
        $config['base_url'] = site_url("top/index/$search");
        
        //$config['total_rows'] = $this->db->query('select count(*) from dic where entry like $search');
        //$config['total_rows'] = $this->db->from('dic')->where(['entry' like $search])->count_all_results();
        $config['total_rows'] = $this->Dictionary->get_dictionary_count($search, $check01, $database, $radiovalue, $maxrow);

        $data['total_rows'] = $config['total_rows'];
        $config['per_page'] = "100";   // I like 100. But Sample is 5
        $config["uri_segment"] = 4;
        $choice = $config["total_rows"]/$config["per_page"];
        $config["num_links"] = 4;
        //$config["num_links"] = floor($choice);

        // integrate bootstrap pagination
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        //$config['first_link'] = false;
        //$config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = 'Prev';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = 'Next';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        //echo "333 : " . $data['page'] . "<br>";
        

        // get  list
        //$data['networks'] = $this->Ipam->get_networks($config["per_page"], $data['page'], NULL);
        $data['dictionary'] = $this->Dictionary->get_dictionary($config["per_page"], $data['page'], $search, $database, $check01, $radiovalue);
        //$data['dictionary'] = $this->Dictionary->get_networks_test($config["per_page"], $data['page'], NULL);

        $data['pagination'] = $this->pagination->create_links();

        $data['sql']  = $this->Dictionary->sql;
        //$data['networks'] =$this->Ipam->get_all_networks();

        //$data['total_rows'] = $config['total_rows'];
        if ($config['total_rows'] < $maxrow ) {
            $data['total_rows'] = $config['total_rows'];
        }else{
            $data['total_rows'] = "over $maxrow";
        }

        $data['start'] = $data['page'] + 1;
        $data['end'] = $data['start'] + $config['per_page'] - 1 ;

		$data['title'] = 'MyFastDictionary';
		$this->load->view('template/header', $data);
		$this->load->view('top_view', $data );
		$this->load->view('template/footer' );
    }




}
