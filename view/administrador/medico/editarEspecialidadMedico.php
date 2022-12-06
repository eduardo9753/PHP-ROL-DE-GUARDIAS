<?php include_once('view/template/head.php') ?>

<!-- Sidebar -->
<?php include_once('view/template/navAdministrador.php'); ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
        <?php include_once('view/template/setting.php'); ?>
        <!-- End of Topbar -->


        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
                <!--helpers verCalendario-->
                <?php include_once('view/administrador/modal/nuevoMedico.php'); ?>
            </div>
            <!-- Content Row -->
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <!--Nombre de mi calendario-->
                    <div class="card">
                        <div class="card-body">
                            <form action="ActualizarEspecialidadMedico" id="" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">MEDICO</label>
                                            <input type="text" name="txt_id" id="txt_id" value="<?php echo $txt_id ?>" hidden>
                                            <input type="text" name="FLG_ESPECIALIDAD" id="FLG_ESPECIALIDAD" value="1" hidden>
                                            <input type="text" name="txt_nombre_medico" id="txt_nombre_medico" value="<?php echo $txt_nombre_medico ?>" class="form-control" readonly>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">ESPECIALIDAD ACTUAL</label>
                                            <input type="text" name="" id="" value="<?php echo $txt_nombre_especialidad ?>" class="form-control" readonly>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-control-label">ASIGNE LA NUEVA ESPECIALIDAD A ACTUALIZAR</label>
                                            <select class="form-control" name="txt_especialidad" id="txt_especialidad">
                                                <?php foreach ($dataEspecialidad as $data) : ?>
                                                    <option value="<?php echo $data->id_especialidad ?>"><?php echo $data->nombre_especialidad ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-12 mx-auto">
                                        <button type="submit" class="btn btn-outline-primary w-100" name="btn_editar_especialidad_medico" id="btn_editar_especialidad_medico">Actualizar Especialidad</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->


    <!-- Footer -->
    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website - <?php echo Date('Y') ?></span>
            </div>
        </div>
    </footer>
    <!-- End of Footer -->
</div>
<!-- End of Content Wrapper -->
<?php include_once('view/template/footer.php'); ?>