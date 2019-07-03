<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->session->login){
            redirect(base_url("Produtos"));
        }
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function check_user()
    {
        $this->form_validation->set_rules("conta", "Conta", "callback_check_now");

        if(!$this->form_validation->run()){
            $this->load->view('login');
        } else{
            $this->session->set_userdata('login', true);
            redirect(base_url("Produtos"));
        }
    }

    public function check_now(){
        $conta= $this->input->post("conta");
        $senha= $this->input->post("senha");

        if($conta=="adm" && $senha=="7323"){
            return true;
        } else{
            $this->form_validation->set_message('check_now', 'Conta ou senha inválida.');
            return false;
        }
    }
}
