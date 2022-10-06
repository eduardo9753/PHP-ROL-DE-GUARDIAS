<?php

//MODEL
include_once('model/modelMedico.php');
include_once('model/modelAdministrador.php');
include_once('model/modelAseets.php');
include_once('model/modelAdministradorMedico.php');


//DATOS
include_once('data/evento.php');
include_once('data/correo.php');
include_once('data/usuario.php');
include_once('data/compania.php');
include_once('data/consultorio.php');
include_once('data/especialidad.php');
include_once('data/especialidadMedico.php');
include_once('data/medico.php');
include_once('data/estadoMedico.php');


//UITLS
include_once('utils/modelSession.php');


class ControlEventoAdministradorMedico
{
    public $MODEL;
    public $SESSION;
    public $ADMIN;
    public $ASSET;
    public $ADMINMEDICO;

    public function __construct()
    {
        $this->MODEL = new ModeloMedico();
        $this->SESSION = new ModeloSession();
        $this->ADMIN = new ModeloEventoAdministrador();
        $this->ASSET = new ModeloAssets();
        $this->ADMINMEDICO = new ModeloAdministradorMedico();
    }


    //DATOS DE LOS MEDICOS
    public function Medico()
    {
        try {

            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Medico') {
                $ruta = 'Medico';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $dataCompanias = $this->ADMINMEDICO->DataCompania();
            $dataCargo = $this->ADMINMEDICO->DataCargo();
            $dataConsultorio = $this->ADMINMEDICO->dataConsultorio();
            $dataEspecialidades = $this->ADMINMEDICO->DataEspecialidades();

            $i = 0;
            $dataMedico = $this->ADMINMEDICO->dataMedico();
            $dataMedicoTitular = $this->ADMINMEDICO->dataMedicoTitular();
            $titulo = "Medicos";
            include_once('view/administrador/medico/registrarMedico.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATOS DE LOS MEDICOS TITULARES
    public function MedicoCargo()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Medico') {
                $ruta = 'Medico';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $txt_id_medico_dependiente =  $_POST["txt_id_medico_dependiente"];
            $txt_nombre_medico_dependiente = $_POST["txt_nombre_medico_dependiente"];
            $dataMedicoTitular = $this->ADMINMEDICO->dataMedicoTitular();
            $titulo = "Asignación de Medicos Dependientes";
            include_once('view/administrador/medico/editarCargoMedico.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA ESPECIALIDAD MEDICO
    public function dataEspecialidadMedicoEditar()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Medico') {
                $ruta = 'Medico';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $medico = new Medico();
            $medico->setid_medico($_POST['id_medico']);
            $titulo = "Actualizar Especialidad";
            $i = 0;
            $dataEspecialidadMedico = $this->MODEL->dataEspecialidadMedicoBYId($medico);
            include_once('view/administrador/medico/especialidadMedico.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //EDITAR ESPECIALIDAD MEDICO
    public function EditarEspecialidadMedico()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Medico') {
                $ruta = 'Medico';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $i = 0;
            $txt_id = $_POST['txt_id']; 
            $txt_nombre_medico = $_POST['txt_nombre_medico'];
            $titulo = "Actualizar Especialidad";
            $dataEspecialidad = $this->ADMINMEDICO->DataEspecialidades();
            include_once('view/administrador/medico/editarEspecialidadMedico.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR ESPECIALIDAD MEDICO
    public function ActualizarEspecialidadMedico()
    {
        try {
            //session start
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $especialidadMedico = new EspecialidadMedico();
            $especialidadMedico->setid($_POST['txt_id']);
            $especialidadMedico->setid_especialidad($_POST['txt_especialidad']);

            $save = $this->MODEL->updateEspecialidadMedico($especialidadMedico);

            if ($save) {
                echo "<script>alert('ESPECIALIDAD ACTUALIZADA CORRECTAMENTE: $usuario!'); window.location='Medico'</script>";
            } else {
                echo "<script>alert('ESPECIALIDAD NO ACTUALIZADA CORRECTAMENTE :( COMUNICAR AL AREA DE SISTEMAS: $usuario!'); window.location='Medico'</script>";
            }
        } catch (Exception $th) {
            echo  $th->getMessage();
        }
    }

    //ACTUALIZAR MEDICO DEPENDIENTE A TITULAR
    public function activarMedicoCargo()
    {
        try {
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $txt_id_medico_dependiente = $_POST['txt_id_medico_dependiente'];
            $txt_codigo_titular = $_POST['txt_codigo_titular'];

            $dataUsuarioMedicoTitular = $this->ADMINMEDICO->UsuarioPorCodigoMedico($txt_codigo_titular);
            $id_usuario_titular = $dataUsuarioMedicoTitular->id_usuario;

            $save = $this->ADMINMEDICO->activarMedicoCargo($txt_id_medico_dependiente, $id_usuario_titular);

            if ($save) {
                echo "<script>alert('MEDICO ASIGNADO CORRECTAMENTE: $usuario!'); window.location='Medico'</script>";
            } else {
                echo "<script>alert('MEDICO NO ASIGNADO CORRECTAMENTE :( COMUNICAR AL AREA DE SISTEMAS: $usuario!'); window.location='Medico'</script>";
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //REGISTRAR UN NUEVO MEDICO
    public function RegistrarMedico()
    {
        try {
            $this->SESSION->isSession();

            $usuario = new Usuario();
            $medico = new Medico();
            $especialidad = new Especialidad();

            if ($_POST['txt_cargo'] == 1) {
                $usuario->setnombreUser($_POST['txt_codigo_medico']);
                $usuario->setcontraUser($_POST['txt_codigo_medico']);
                $usuario->setfoto('foto.jpg');
                $usuario->setperfil('MEDICO');

                $saveUsuario = $this->ADMINMEDICO->insertUsuario($usuario);

                if ($saveUsuario) {
                    $id = $this->ASSET->lastIdUsuario('usuario');
                    $ultimoIdUsuario = $id[0];

                    $medico->setnombre_medico($_POST['txt_medico']);
                    $medico->setcodigo_medico($_POST['txt_codigo_medico']);
                    $medico->setid_consultorio(137);  //txt_consultorio
                    $medico->setid_estado_medico('1');
                    $medico->setid_compania($_POST['txt_compania']);
                    $medico->setid_usuario($ultimoIdUsuario);
                    $medico->setid_cargo($_POST['txt_cargo']);
                    $medico->setcorreo($_POST['txt_correo']);
                    $medico->settelefono($_POST['txt_telefono']);
                    $medico->setfoto('public/img/foto.jpg');

                    $saveMedico = $this->ADMINMEDICO->insertMedico($medico);

                    if ($saveMedico) {
                        $id = $this->ASSET->lastIdMedico('medico');
                        $ultimoIdMedico = $id[0];

                        $medico->setid_medico($ultimoIdMedico);
                        $especialidad->setid_especialidad($_POST['txt_especialidad']);

                        $save = $this->ADMINMEDICO->insertEspecialidadMedico($especialidad, $medico);

                        if ($save) {
                            echo 1;
                        } else {
                            echo 0;
                        }
                    } else {
                        echo 0;
                    }
                } else {
                    echo 0;
                }
            } else {
                $medico->setnombre_medico($_POST['txt_medico']);
                $medico->setcodigo_medico($_POST['txt_codigo_medico']);
                $medico->setid_consultorio(137);
                $medico->setid_estado_medico('1');
                $medico->setid_compania($_POST['txt_compania']);
                $medico->setid_usuario(null);  //LE PASAMOS NULL 
                $medico->setid_cargo($_POST['txt_cargo']);
                $medico->setcorreo($_POST['txt_correo']);
                $medico->settelefono($_POST['txt_telefono']);
                $medico->setfoto('public/img/foto.jpg');

                $saveMedico = $this->ADMINMEDICO->insertMedico($medico);

                if ($saveMedico) {
                    $id = $this->ASSET->lastIdMedico('medico');
                    $ultimoIdMedico = $id[0];

                    $medico->setid_medico($ultimoIdMedico);
                    $especialidad->setid_especialidad($_POST['txt_especialidad']);

                    $save = $this->ADMINMEDICO->insertEspecialidadMedico($especialidad, $medico);

                    if ($save) {
                        echo 1;
                    } else {
                        echo 0;
                    }
                } else {
                    echo 0;
                }
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //DATOS DE LOS CONSULTORIO
    public function Consultorios()
    {
        try {
            $this->SESSION->isSession();

            //color de links
            if (isset($_REQUEST['ruta']) == 'Consultorios') {
                $ruta = 'Consultorios';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $i = 0;
            $dataConsultorio = $this->ADMINMEDICO->dataConsultorio();
            $titulo = "Consultorios";
            include_once('view/administrador/medico/consultorios.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //REGISTRAR UN NUEVO CONSULTORIO
    public function registrarConsultorio()
    {
        try {
            $this->SESSION->isSession();
            $consultorio = new Consultorio();
            $consultorio->setnombre_consultorio($_POST['txt_consultorio']);

            $save = $this->ADMINMEDICO->insertConsultorio($consultorio);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR CONSULTORIO
    public function ActualizarConsultorio()
    {
        try {
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $consultorio = new Consultorio();
            $consultorio->setnombre_consultorio($_POST['txt_nombre_consultorio']);
            $consultorio->setid_consultorio($_POST['txt_id_consultorio']);
            $consultorio->setestado($_POST['txt_estado_consultorio']);

            $save = $this->ADMINMEDICO->updateConsultorio($consultorio);

            if ($save) {
                echo "<script>alert('CONSULTORIO ACTUALIZADO CORRECTAMENTE: $usuario!'); window.location='Consultorios'</script>";
            } else {
                echo "<script>alert('CONSULTORIO NO ACTUALIZADO CORRECTAMENTE . COMUNICAR A SISTEMAS: $usuario!'); window.location='Consultorios'</script>";
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //DATOS DE LAS ESPECIALIDADES
    public function Especialidades()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Especialidades') {
                $ruta = 'Especialidades';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $i = 0;
            $dataEspecialidades = $this->ADMINMEDICO->DataEspecialidades();
            $titulo = "Especialidades";
            include_once('view/administrador/medico/especialidades.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //REGISTRAR NUEVA ESPECIALIDAD
    public function registrarEspecialidad()
    {
        try {
            $this->SESSION->isSession();
            $especialidad = new Especialidad();
            $especialidad->setnombre_especialidad($_POST['txt_especialidad']);

            $save = $this->ADMINMEDICO->insertEspecialidad($especialidad);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR LA ESPECIALIDAD
    public function ActualizarEspecialidad()
    {
        try {
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $especialidad = new Especialidad();
            $especialidad->setnombre_especialidad($_POST['txt_nombre_especialidad']);
            $especialidad->setid_especialidad($_POST['txt_id_especialidad']);
            $especialidad->setestado($_POST['txt_estado_especialidad']);


            $save = $this->ADMINMEDICO->updateEspecialidad($especialidad);

            if ($save) {
                echo "<script>alert('REGISTRO ACTUALIZADO CORRECTAMENTE: $usuario!'); window.location='Especialidades'</script>";
            } else {
                echo "<script>alert('REGISTRO NO ACTUALIZADO CORRECTAMENTE , COMUNICAR A SISTEMAS $usuario!'); window.location='Especialidades'</script>";
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATOS DE LAS COMPAÑIAS
    public function Companias()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'Companias') {
                $ruta = 'Companias';
                $show_medico_gestion = 'show';
                $active_medico_gestion = 'active';
            }

            $i = 0;
            $dataCompanias = $this->ADMINMEDICO->DataCompania();
            $titulo = "Compañias";
            include_once('view/administrador/medico/companias.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //REGISTRAR NUEVA COMPAÑIA
    public function registrarCompania()
    {
        try {
            $this->SESSION->isSession();
            $compania = new Compania();
            $compania->setnombre_compania($_POST['txt_compania']);

            $save = $this->ADMINMEDICO->insertCompania($compania);

            if ($save) {
                echo 1;
            } else {
                echo 0;
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR COMPAÑIAS
    public function ActualizarCompanias()
    {
        try {
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $compania = new Compania();
            $compania->setnombre_compania($_POST['txt_nombre_compania']);
            $compania->setid_compania($_POST['txt_id_compania']);
            $compania->setestado($_POST['txt_estado_compania']);


            $save = $this->ADMINMEDICO->updateCompania($compania);

            if ($save) {
                echo "<script>alert('REGISTRO ACTUALIZO CORRECTAMENTE: $usuario!'); window.location='Companias'</script>";
            } else {
                echo "<script>alert('REGISTRO NO ACTUALIZO CORRECTAMENTE: $usuario!'); window.location='Companias'</script>";
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //LISTA DE USUARIOS TITULARES
    public function listarUsuarios()
    {
        try {
            $this->SESSION->isSession();
            //color de links
            if (isset($_REQUEST['ruta']) == 'listarUsuarios') {
                $ruta = 'listarUsuarios';
                $show_usuario = 'show';
                $active_usuario = 'active';
            }

            $i = 0;
            $titulo = "Lista de Usuarios Titulares";
            $dataUsuario = $this->ADMINMEDICO->DataUsuarioTitular();
            include_once('view/administrador/usuarios/usuarioTitulares.php');
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTIVAR ESTADO METODO
    public function ActivarUsuarioMedico()
    {
        try {
            $this->SESSION->isSession();
            $usuario = $_SESSION["nombre_usuario"];

            $medico = new Medico();
            $medico->setid_usuario($_POST['txt_id_usuario']);
            $medico->setid_estado_medico(1);

            $save = $this->ADMINMEDICO->activarUsuarioMedico($medico);

            if ($save) {
                echo "<script>alert('REGISTRO ACTIVADO CORRECTAMENTE: $usuario!'); window.location='listarUsuarios'</script>";
            } else {
                echo "<script>alert('REGISTRO NO ACTIVADO CORRECTAMENTE . COMUNICAR A SISTEMAS: $usuario!'); window.location='listarUsuarios'</script>";
            }
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
