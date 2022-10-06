<?php

//MODEL
include_once('model/modelMedico.php');
include_once('model/modelAseets.php');

//DATOS
include_once('data/evento.php');
include_once('data/correo.php');


//UITLS
include_once('utils/modelSession.php');


class ControlMedico
{
    public $MODEL;
    public $SESSION;
    public $ADMINMEDICO;
    public $ASSET;

    public function __construct()
    {
        $this->MODEL = new ModeloMedico();
        $this->SESSION = new ModeloSession();
        $this->ADMINMEDICO = new ModeloAdministradorMedico();
        $this->ASSET = new ModeloAssets();
    }

    //vista registrar evento del horario
    public function registrarEvento()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'registrarEvento') {
                $ruta = 'registrarEvento';
                $show_evento = 'show';
                $active_evento = 'active';
            }
            $dataMedico = $this->MODEL->allMedicosById($_SESSION["id_medico"]);
            $dataGuardia = $this->MODEL->dataHorarioGuardia();
            $titulo = "Registrar Horario Medico";
            include_once('view/medico/eventos/registrarEvento.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    public function fechaMayor()
    {
        $dayhoy = Date('Y-m-d');
        $dayMania = "2022-09-30";

        if ($dayhoy > $dayMania) {
            echo 'FECHA M : ' . $dayhoy;
        } else {
            echo 'FECHA M2: ' . $dayMania;
        }
    }

    //CALENDARIO POR ESPECIALIDAD DE MEDICOS
    public function calendarioPorEspecialidadMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $dataEspecialidad = $this->ADMINMEDICO->DataEspecialidades();
            $mes = Date('Y') . '-' . $this->ASSET->mesActual();

            if (isset($_POST['cbo_especialidad'])) {
                $id_especialidad =  $_POST['cbo_especialidad'];
            } else {
                $id_especialidad =  1;
            }

            include_once('view/medico/dashboard/calendarioPorEspecialidad.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //CONSUMO DE DATOS PARA EL CALENDAR DE CADA MEDICO POR ID
    public  function getAllEventIDMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();

            //HORARIO DEL MEDICO POR ID
            $data = $this->MODEL->allEvent($_SESSION["nombre_medico"]);
            echo json_encode($data);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //REGISTRAR ESPECIALIDAD
    public function listaEspecialidad()
    {
        try {
            //session start
            $this->SESSION->isSession();
            if (isset($_REQUEST['ruta']) == 'listaEspecialidad') {
                $ruta = 'listaEspecialidad';
                $show_lista_especialidad = 'show';
                $active_lista_especialidad = 'active';
            }

            $i = 0;
            $titulo = 'Mis Especialidades';
            $medico = new Medico();
            $medico->setid_medico($_SESSION['id_medico']);
            $dataEspecialidadMedico = $this->MODEL->dataEspecialidadMedicoBYId($medico);
            $dataEspecialidades = $this->ADMINMEDICO->DataEspecialidades();

            include_once('view/medico/especialidad/especialidad.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //REGISTRO DE ESPECIALIDAD
    public function registrarEspecialidadMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $medico = new Medico();
            $especialidad = new Especialidad();
            $medico->setid_medico($_SESSION["id_medico"]);
            $especialidad->setid_especialidad($_POST['txt_especialidad']);

            $save = $this->MODEL->insertEspecialidadMedico($especialidad, $medico);

            if ($save) {
                header('Location:listaEspecialidad');
            } else {
                header('Location:listaEspecialidad');
            }
        } catch (Exception $th) {
            echo  $th->getMessage();
        }
    }

    //CAMBIAR DE NOMBRE YA QUE SE REPITE EN EL CONTROADMINISTRADORMEDICO.PHP
    /*public function actualizarEspecialidadMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $especialidadMedico = new EspecialidadMedico();
            $especialidadMedico->setid($_POST['txt_id']);
            $especialidadMedico->setid_especialidad($_POST['txt_especialidad']);

            $save = $this->MODEL->updateEspecialidadMedico($especialidadMedico);

            if ($save) {
                header('Location:listaEspecialidad');
            } else {
                header('Location:listaEspecialidad');
            }
        } catch (Exception $th) {
            echo  $th->getMessage();
        }
    }*/


    //ACTUALIZAR CUANDO EL CINTILLO SE MUEVA DE LUGAR
    /*public function moverEvento()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $id_usuario = $_SESSION["id_usuario"];

            $evento = new Evento();
            $evento->settitle($_POST['txt_titulo']);
            $evento->setdescripcion($_POST['txt_descripcion']);
            $evento->setid_medico($_POST['txt_id_medico']);
            $evento->setcolor($_POST['txt_color']);
            $evento->settextColor($_POST['txt_color_texto']);
            $evento->setstart($_POST['txt_fecha_inicio']);
            $evento->setend($_POST['txt_fecha_fin']);
            $evento->setid($_POST['txt_id']);

            $save = $this->MODEL->updateMoverEvento($evento);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }*/


    //TRAER LOS DATOS DEL EVENTO POR ID PARA PINTARLOS Y ACTUALIZARLOS
    public function editarEvento()
    {
        try {
            //session start
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'editarEvento') {
                $ruta = 'registrarEvento'; //parta pintar el enlace registrar evento
                $show_evento = 'show';
                $active_evento = 'active';
            }
            if ($_REQUEST['btn-editar-evento']) {
                $evento = new Evento();
                $evento->setid($_POST['txt_id']);
                $titulo = "Actualizar Mi Horarios";
                $dataEvento = $this->MODEL->eventoById($evento);
                include_once('view/medico/eventos/actualizarEvento.php');
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR EVENTO SOLO LAS FECHAS DE ESE REGISTRO
    public function actualizarEvento()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $id_usuario = $_SESSION["id_usuario"];

            $evento = new Evento();
            $evento->setdescripcion($_POST['txt_descripcion']);
            $evento->setstart($_POST['txt_fecha_inicio']);
            $evento->setend($_POST['txt_fecha_fin']);
            $evento->setid($_POST['txt_id']);

            $save = $this->MODEL->updateEvento($evento);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //INSERTAMOS LOS DATOS DE LOS EVENTOS CADA 7 DIAS Y POR INTERVALOS DE FECHAS
    public function insertEvento()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $id_usuario = $_SESSION["id_usuario"];
            $fecha_actual = date("Y-m-d" . "00:00:00");

            $por_dia = 1;

            $fecha_inicio_ = $this->SESSION->AnioMesActual($_POST['txt_fecha_inicio']);
            $fecha_final_ = $this->SESSION->AnioMesActual($_POST['txt_fecha_fin']);

            //PARA RECORRIDO DEL WHILE SE CAPTURA EL PRIMER DIA Y EL ULTIMO DIA Y SE LE SUMA LOS DIAS QUE SE REQUIERE
            $dia_incio_mes = $this->SESSION->DiaPrimerUltimo($_POST['txt_fecha_inicio']);
            $dia_final_mes = $this->SESSION->DiaPrimerUltimo($_POST['txt_fecha_fin']);

            //HORARIO INICIO MES TURNO MAÑANA
            $hora_incio_mes = $this->SESSION->horasMinutos($_POST['txt_fecha_inicio']);
            $hora_final_mes = $this->SESSION->horasMinutos($_POST['txt_fecha_fin']);

            //HORARIO INICIO MES TURNO DOBLE
            $hora_incio_mes_tarde = $_POST['txt_hora_turno_tarde_inicio'];
            $hora_final_mes_tarde = $_POST['txt_hora_turno_tarde_fin'];

            //TURNO DE LA GUARDIA
            $turno_guardia = 4; //$_POST['txt_turno_guardia'];

            //CUANDO ES TRUE LA FRANJA CON COLOR APARACE
            if ($fecha_inicio_ <= $fecha_actual && $fecha_final_ <= $fecha_actual) {
                $allDay = "";
            } else {
                $allDay = ""; //$allDay = "true";
            }

            //$contador = 1;
            //while ($dia_incio_mes <= $dia_final_mes) :
                /*ACTIVACION DEL TURNO DOBLE HORARARIO
                if (isset($_POST['check_turno_tarde'])) {
                    $fecha_inicio_aumento = $fecha_inicio_ . "-" . $dia_incio_mes . " " . $hora_incio_mes_tarde;
                    $fecha_final_aumento = $fecha_inicio_ . "-" . $dia_incio_mes . " " . $hora_final_mes_tarde;
                    //GREGAR OTRO PARA LA TARDE
                    $evento = new Evento();
                    $evento->settitle($_POST['txt_titulo']);
                    $evento->setdescripcion($_POST['txt_descripcion']);
                    $evento->setid_medico($_POST['txt_medico']);
                    $evento->setcolor($_POST['txt_color']);
                    $evento->settextColor($_POST['txt_color_texto']);
                    $evento->setstart($fecha_inicio_aumento);
                    $evento->setend($fecha_final_aumento);
                    $evento->setallDay($allDay);
                    $evento->setid_estado('1');
                    $evento->setid_guardia($turno_guardia); //$_POST['txt_turno_guardia']
                    $save = $this->MODEL->saveEvento($evento);
                }*/

                //FECHA DE HORIRIO UN SOLO TURNO
                //$fecha_inicio_aumento = $fecha_inicio_ . "-" . $dia_incio_mes . " " . $hora_incio_mes;
                //$fecha_final_aumento = $fecha_inicio_ . "-" . $dia_incio_mes . " " . $hora_final_mes;

                $fecha_inicio_aumento = $fecha_inicio_ . "-" . $dia_incio_mes . " " . $hora_incio_mes;
                $fecha_final_aumento = $fecha_inicio_ . "-" . $dia_final_mes . " " . $this->SESSION->formatoHoras($hora_final_mes);

                //GREGAR OTRO PARA LA TARDE
                $evento = new Evento();
                $evento->settitle($_POST['txt_titulo']);
                $evento->setdescripcion('');       //$_POST['txt_descripcion']
                $evento->setid_medico($_POST['txt_medico']);
                $evento->setcolor('#ea7910');      //$_POST['txt_color']
                $evento->settextColor('#ffffff');  //$_POST['txt_color_texto']
                $evento->setstart($fecha_inicio_aumento);
                $evento->setend($fecha_final_aumento);
                $evento->setallDay($allDay);
                $evento->setid_estado('1');
                $evento->setid_guardia($turno_guardia); //$_POST['txt_turno_guardia']
                $save = $this->MODEL->saveEvento($evento);

                //CADA RECORRIDO SE SUMA LOS DIAS APLICADOS ES POR ESO QUE SE PONE DE INICIO A FINAL CUANDO SE USA BUCLE WHILE
                //$dia_incio_mes = $dia_incio_mes + $por_dia;
                //$contador++;
            //endwhile;

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ELIMINAR EVENTO ADM
    public function EliminarEventoMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $id_evento = $_POST['txt_id_eliminar_evento'];
            $delete = $this->MODEL->deleteEventoMedico($id_evento);

            if ($delete) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    /*public function insertEvento()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $id_usuario = $_SESSION["id_usuario"];
            $fecha_actual = date("Y-m-d" . "00:00:00");
            //$fecha_actual = date("Y-m-d H:i:s");
            //$fecha_mayor = date("Y-m-d H:i:s", strtotime($fecha_actual . "+ 1 days"));

            $fecha_inicio_ = $this->SESSION->formatFecha($_POST['txt_fecha_inicio']);
            $fecha_final_ = $this->SESSION->formatFecha($_POST['txt_fecha_fin']);

            //PARA QUE SE PUEDE VISUALIZAR LA FRANJA
            if ($fecha_inicio_ <= $fecha_actual && $fecha_final_ <= $fecha_actual) {
                $allDay = "true";
            } else {
                $allDay = "";
            }

            $evento = new Evento();
            $evento->settitle($_POST['txt_titulo']);
            $evento->setdescripcion($_POST['txt_descripcion']);
            $evento->setpaciente($_POST['txt_paciente']);
            $evento->setmedico($_POST['txt_medico']);
            $evento->setcolor($_POST['txt_color']);
            $evento->settextColor($_POST['txt_color_texto']);
            $evento->setstart($_POST['txt_fecha_inicio']);
            $evento->setend($_POST['txt_fecha_fin']);
            $evento->setallDay($allDay);
            $evento->setid_estado('1');
            $evento->setid_usuario($id_usuario);

            $save = $this->MODEL->saveEvento($evento);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }*/
}
