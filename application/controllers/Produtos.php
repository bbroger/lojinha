<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produtos extends CI_Controller 
{
    public function index()
    {
        $this->load->view('cadastrar_produtos');
    }
}