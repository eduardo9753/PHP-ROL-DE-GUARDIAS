<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

include_once('config/conexionOracle.php');
include_once('config/conexionMysql.php');

class ModeloVisorGuardias
{

    public $PDO;
    public $MYSQL;

    public function __construct()
    {
        try {
            $this->PDO = new ConexionOracle(); //INICIANDO LA CONEXION A LA BD
            $this->MYSQL = new ClassConexion();
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    public function dataMedicosTitulares()
    {
        try {
            $sql = "SELECT e.id_especialidad , e.nombre_especialidad FROM especialidad e";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA HORARIOS MEDICOS POR ESPECIALIDAD
    public function allEventByEspecialidad($txt_id_especialidad, $txt_mes_especialidad)
    {
        try {
            $sql = "SELECT eve.id , 
             med.nombre_medico AS 'title',
             eve.color AS 'backgroundColor',
             eve.textColor AS 'textColor',
             eve.`allDay` AS 'allDay',
             eve.`START` AS 'start',
             eve.`end` AS 'end'
             FROM especialidad_medico esme
             INNER JOIN especialidad es ON es.id_especialidad = esme.id_especialidad
             INNER JOIN medico med ON med.id_medico = esme.id_medico
             INNER JOIN evento eve ON med.id_medico = eve.id_medico
             WHERE es.id_especialidad IN(?) AND DATE_FORMAT(eve.`START`, '%Y-%m') = ?";
            $stm = $this->MYSQL->ConectarBD()->prepare($sql);
            $stm->execute(array(
                $txt_id_especialidad,
                $txt_mes_especialidad
            ));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //PINTA NUMERO DEL MES SIGUIENTE
    public function mesSiguiente()
    {
        $meses = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $meseSiguiente =  $meses[date('n')];
        return $meseSiguiente;
    }

    public function mesActual()
    {
        $meses = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");
        $meseSiguiente =  $meses[date('n-') - 1];
        return $meseSiguiente;
    }
}
