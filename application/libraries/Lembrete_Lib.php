<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Lembrete_Lib
{
    private $CI;

    public function __construct()
    {
        $this->CI = &get_instance();
    }

    public function consulta_pendencias()
    {
        $this->CI->load->model('Pendencias_model');
        $pendencias= $this->CI->Pendencias_model->pendencias();

        $arr['lembretes']= 0;
        $arr['vencidos']= 0;
        $hoje= date('Y-m-d');

        if(count($pendencias) > 0){
            $vence= 0;
            foreach ($pendencias as $key => $value) {
                if($value['vencimento'] <= $hoje){
                    $vence++;
                }
            }
            $arr['lembretes']= count($pendencias);
            $arr['vencidos']= $vence;
        }
        if($arr['lembretes'] === 0){
            $arr['lembretes']= '<button class="btn btn-info disabled">Não existem lembretes</button>';
        } else if($arr['lembretes'] === 1){
            $arr['lembretes']= '<button class="btn btn-info">Existe 1 lembrete</button>';
        } else{
            $arr['lembretes']= '<button class="btn btn-info">Existem '.$arr['lembretes'].' lembretes</button>';
        }

        if($arr['vencidos'] === 0){
            $arr['vencidos']= '<button class="btn btn-danger disabled">Não existem lembretes urgentes</button>';
        } else if($arr['vencidos'] === 1){
            $arr['vencidos']= '<button class="btn btn-danger">1 lembrete urgente</button>';
        } else{
            $arr['vencidos']= '<button class="btn btn-danger">'.$arr['vencidos'].' lembretes urgentes</button>';
        }

        return $arr;
    }
}