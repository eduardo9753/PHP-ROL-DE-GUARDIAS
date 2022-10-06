<?php

//MODEL
include_once('model/modelLogin.php');
include_once('utils/modelMensaje.php');
include_once('model/modelAseets.php');
include_once('model/modelMedico.php');


//DATOS
include_once('data/usuario.php');

//UITLS
include_once('utils/modelSession.php');


class ControlIndex
{
    public $MODEL;
    public $MODELMEDICO;
    public $MSG;
    public $ASSET;
    public $SESSION;

    public function __construct()
    {
        $this->MODELMEDICO = new ModeloMedico();
        $this->MODEL = new ModeloLogin();
        $this->MSG = new ModeloMensaje();
        $this->ASSET = new ModeloAssets();
        $this->SESSION = new ModeloSession();
    }

    public  function index() //VISTA INDEX
    {
        try {
            include_once('view/login/login.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function dashboardADM()
    {
        try {
            //session start
            $this->SESSION->isSession();

            //color de links
            if (isset($_REQUEST['ruta']) == 'dashboardADM') {
                $ruta = 'dashboardADM';
            }

            $titulo = "Dashboard";
            include_once('view/administrador/dashboard/menu.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    public function dashboardMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();

            //color de links
            if (isset($_REQUEST['ruta']) == 'dashboardMedico') {
                $ruta = 'dashboardMedico';
            }


            //PARA EL COMBO BOX
            $dataMedico = $this->MODELMEDICO->allMedicosById($_SESSION["id_usuario"]);
            $dataGuardia = $this->MODELMEDICO->dataHorarioGuardia();
            $titulo = "Dashboard - TITULAR : " . $_SESSION["nombre_medico"];

            if (Date('m') == '12') { //SI ES MES EL 12 , JALAMOS EL AÑO QUE SI Y EL PRIMER MES SINO
                $mes = $this->ASSET->anioSiguiente() . "-01";
            } else { //JALAMOS EL MES SIGUIENTE CON EL AÑO ACTUAL
                $mes = Date('Y')."-".$this->ASSET->mesSiguiente();
            }
            include_once('view/medico/dashboard/menu.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }



    public function NoEncontrado()
    {
        $titulo =  "PAGIN NO ENCONTRADA";
        session_start();
        $_SESSION['CONTROL'] = 0;
        $_SESSION['CONTROL'] = '';
        include_once('view/404/noEncontrado.php');
    }


    public function Close()
    {
        try {
            session_start();
            session_destroy();
            session_unset();
            $_SESSION['CONTROL'] = 0;
            $_SESSION['CONTROL'] = '';
            include_once('view/login/login.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
