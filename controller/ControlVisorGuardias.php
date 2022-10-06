<?php

include_once('model/modelVisorGuardias.php');


class ControlVisorGuardias
{
    public $MODELGUARDIAS;

    public function __construct()
    {
        $this->MODELGUARDIAS = new ModeloVisorGuardias();
    }

    public function MedicoEspecialidad()
    {
        try {
           
            $titulo = "ESPECIALIDADES";
            $dataMedicoEspecialidad =  $this->MODELGUARDIAS->dataMedicosTitulares();
            $i = 0;
            include_once('view/guardias/guardias.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //CONSUMO DE DATO AVENT POR ESPECIALIDAD
    public function getAllEventCalendarioPorEspecialidadVisor()
    {
        try {
            $txt_id_especialidad = $_REQUEST['txt_id_especialidad'];
            $txt_mes_especialidad = $_REQUEST['txt_mes_especialidad'];
            $data = $this->MODELGUARDIAS->allEventByEspecialidad($txt_id_especialidad, $txt_mes_especialidad);
            echo json_encode($data);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function visorMedicoGuardias()
    {
        try {
            //color de links
            if (isset($_REQUEST['ruta']) == 'MedicoEspecialidad') {
                $ruta = 'MedicoEspecialidad';
            }
            $titulo = "GUARDIAS";
            $txt_id_especialidad = $_POST['txt_id_especialidad'];
            $mes = Date('Y') . '-' . $this->MODELGUARDIAS->mesActual();
            include_once('view/guardias/visorGuardias.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
