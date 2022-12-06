<?php

include_once('model/modelVisorGuardias.php');
include_once('model/modelAseets.php');


class ControlVisorGuardias
{
    public $MODELGUARDIAS;
    public $ASSET;

    public function __construct()
    {
        $this->MODELGUARDIAS = new ModeloVisorGuardias();
        $this->ASSET = new ModeloAssets();
    }

    public function MedicoEspecialidad()
    {
        try {

            $titulo = "ESPECIALIDADES";
            $dataMedicoEspecialidad =  $this->MODELGUARDIAS->dataMedicosTitulares();
            $mes = $this->ASSET->mesActualCadena();
            $mesSiguiente = $this->ASSET->mesAnteriorCadena();
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
            if ($_POST['flag_mes'] == '1') {
                $mes = Date('Y') . '-' . $this->MODELGUARDIAS->mesActual();
            } else {
                $mes = Date('Y') . '-' . $this->MODELGUARDIAS->mesAnterior();
            }

            include_once('view/guardias/visorGuardias.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
