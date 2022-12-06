<?php

include_once('config/conexionMysql.php');

class ModeloAdministradorMedico
{
    public $PDO;

    public function __construct()
    {
        try {
            $this->PDO = new ClassConexion(); //INICIANDO LA CONEXION A LA BD
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA DE TODOS LOS MEDICOS
    public function dataMedico()
    {
        try {
            $sql = 'SELECT * FROM medico m 
            INNER JOIN consultorio c ON c.id_consultorio = m.id_consultorio
            INNER JOIN compania com ON com.id_compania = m.id_compania
            INNER JOIN estado_medico estame ON estame.id_estado_medico = m.id_estado_medico
            INNER JOIN cargo_medico car ON car.id_cargo = m.id_cargo
            INNER JOIN especialidad_medico esme ON esme.id_medico = m.id_medico 
            INNER JOIN especialidad es ON es.id_especialidad = esme.id_especialidad
            WHERE m.id_medico NOT IN(410) 
            ORDER BY m.nombre_medico ASC ';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA DE TODOS LOS MEDICOS
    public function dataMedicoTitular()
    {
        try {
            $sql = 'SELECT * FROM medico m 
            INNER JOIN consultorio c ON c.id_consultorio = m.id_consultorio
            INNER JOIN compania com ON com.id_compania = m.id_compania
            INNER JOIN estado_medico estame ON estame.id_estado_medico = m.id_estado_medico
            INNER JOIN cargo_medico car ON car.id_cargo = m.id_cargo 
            INNER JOIN usuario usu ON usu.id_usuario = m.id_usuario
            WHERE car.id_cargo in(1) ORDER BY m.nombre_medico ASC';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //USUARIO POR CODIGO MEDICO 
    public function UsuarioPorCodigoMedico($txt_codigo_titular)
    {
        try {
            $sql = 'SELECT * FROM usuario u WHERE u.nombre_usuario =?';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute(array($txt_codigo_titular));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //USUARIO POR CODIGO MEDICO 
    public function activarMedicoCargo($txt_id_medico_dependiente, $id_usuario_titular)
    {
        try {
            $sql = "UPDATE medico m SET m.id_usuario =? WHERE m.id_medico=?";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $id_usuario_titular,
                    $txt_id_medico_dependiente
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ESTADO DE LOS MEDICOS 
    public function DataEstadoMedico()
    {
        try {
            $sql = 'SELECT * FROM estado_medico';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT DATA NUEVO MEDICO
    public function insertMedico(Medico $medico)
    {
        try {
            $sql = "INSERT INTO medico(nombre_medico,codigo_medico,id_consultorio,id_estado_medico,id_compania,id_usuario,id_cargo,correo,telefono,foto) VALUES (?,?,?,?,?,?,?,?,?,?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $medico->getnombre_medico(),
                    $medico->getcodigo_medico(),
                    $medico->getid_consultorio(),
                    $medico->getid_estado_medico(),
                    $medico->getid_compania(),
                    $medico->getid_usuario(),
                    $medico->getid_cargo(),
                    $medico->getcorreo(),
                    $medico->gettelefono(),
                    $medico->getfoto()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA DE LOS CONSULTORIO
    public function dataConsultorio()
    {
        try {
            $sql = 'SELECT * FROM consultorio';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT DATA NUEVO CONSULTORIO
    public function insertConsultorio(Consultorio $consultorio)
    {
        try {
            $sql = "INSERT INTO `consultorio` (`nombre_consultorio`) VALUES (?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $consultorio->getnombre_consultorio()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR CONSULTORIO
    public function updateConsultorio(Consultorio $consultorio)
    {
        try {
            $sql = "UPDATE consultorio SET nombre_consultorio=?,
            estado=? WHERE id_consultorio=?";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $consultorio->getnombre_consultorio(),
                    $consultorio->getestado(),
                    $consultorio->getid_consultorio()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA DE LAS COMPAÑIAS
    public function DataCompania()
    {
        try {
            $sql = 'SELECT * FROM compania';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA CARGO
    public function DataCargo()
    {
        try {
            $sql = 'SELECT * FROM cargo_medico';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT DATA NUEVA COMPAÑIA
    public function insertCompania(Compania $compania)
    {
        try {
            $sql = "INSERT INTO `compania` (`nombre_compania`) VALUES (?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $compania->getnombre_compania()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTUALIZAR DATA COMPAÑIA
    public function updateCompania(Compania $compania)
    {
        try {
            $sql = "UPDATE compania SET nombre_compania=?,
                           estado=? WHERE id_compania=?";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $compania->getnombre_compania(),
                    $compania->getestado(),
                    $compania->getid_compania()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //DATA DE LAS ESPECIALIDADES
    public function DataEspecialidades()
    {
        try {
            $sql = 'SELECT * FROM especialidad espe ORDER BY espe.nombre_especialidad  ASC ';
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT DATA NUEVA ESPECIALIDAD
    public function insertEspecialidad(Especialidad $especialidad)
    {
        try {
            $sql = "INSERT INTO `especialidad` (`nombre_especialidad`) VALUES (?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $especialidad->getnombre_especialidad()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTULIZAR ESPECIALIDAD
    public function updateEspecialidad(Especialidad $especialidad)
    {
        try {
            $sql = "UPDATE especialidad SET nombre_especialidad=?,
            estado=? WHERE id_especialidad=?";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $especialidad->getnombre_especialidad(),
                    $especialidad->getestado(),
                    $especialidad->getid_especialidad()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT NUEVO USUARIO
    public function insertUsuario(Usuario $usuario)
    {
        try {
            $sql = "INSERT INTO usuario(nombre_usuario,contra_usuario,perfil,foto) VALUES(?,?,?,?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $usuario->getnombreUser(),
                    $usuario->getcontraUser(),
                    $usuario->getperfil(),
                    $usuario->getfoto()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }


    //LISTA DE USUARIOS
    public function DataUsuarioTitular()
    {
        try {
            $sql = "SELECT m.id_medico, m.nombre_medico,esta.estado,u.id_usuario,
            u.nombre_usuario,u.contra_usuario, u.perfil , cargo.nombre_cargo
            FROM medico m 
            INNER JOIN usuario u ON m.id_usuario = u.id_usuario
            INNER JOIN estado_medico esta ON m.id_estado_medico = esta.id_estado_medico
            INNER JOIN cargo_medico cargo on cargo.id_cargo = m.id_cargo
            AND cargo.nombre_cargo = 'TITULAR'
            ORDER BY m.id_medico ASC";
            $stm = $this->PDO->ConectarBD()->prepare($sql);
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //ACTIVAR USUARIO
    public function activarUsuarioMedico(Medico $medico)
    {
        try {
            $sql = "UPDATE medico m
            SET m.id_estado_medico = ? WHERE m.id_usuario = ?";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $medico->getid_estado_medico(),
                    $medico->getid_usuario()
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }

    //INSERT MUCHOS A MUCHOS ESPECIALIDAD - MEDICO
    public function insertEspecialidadMedico(Especialidad $especialidad, Medico $medico)
    {
        try {
            $sql = "INSERT INTO especialidad_medico(id_medico,id_especialidad) VALUES(?,?)";
            $stm = $this->PDO->ConectarBD()->prepare($sql)->execute(
                array(
                    $medico->getid_medico(),
                    $especialidad->getid_especialidad(),
                )
            );
            return $stm;
        } catch (Exception $th) {
            echo $th->getMessage();
        }
    }
}
