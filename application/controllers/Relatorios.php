<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relatorios extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!$this->session->login){
            redirect(base_url("Login"));
        }
        $this->load->model('Relatorios_model');
    }

    public function index()
    {
        $this->load->view('head');
        $this->load->view('relatorios');
    }
}