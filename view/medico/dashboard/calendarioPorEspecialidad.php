<?php include_once('view/template/head.php') ?>

<!-- Sidebar -->
<?php include_once('view/template/navMedico.php'); ?>
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
                <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                <!--helpers verCalendario-->
                <?php //include_once('view/helpers/verCalendarioADM.php'); 
                ?>
            </div>
            <!-- Content Row -->
            <div class="row">
                <div class="col-md-12">
                    <form action="calendarioPorEspecialidad" id="" method="POST">
                        <div class="col-md-4">
                            <select name="cbo_especialidad" id="cbo_especialidad" class="form-control">
                                <?php foreach ($dataEspecialidad as $data) : ?>
                                    <option value="<?php echo $data->id_especialidad ?>"><?php echo $data->nombre_especialidad ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="text" value="<?php echo $mes ?>" name="txt_mes_especialidad" id="txt_mes_especialidad" hidden>
                            <input type="text" value="<?php echo $id_especialidad ?>" name="txt_id_especialidad" id="txt_id_especialidad" hidden>

                        </div>
                        <div class="col-md-4 mt-2">
                            <button type="submit" name=" id=" class="btn btn-success mb-3 w-100">Ver Datos</button>
                        </div>
                    </form>

                    <!--Nombre de mi calendario-->
                    <div id='calendarioPorMes' class="calendar"></div>
                    <!-- Modal  EDITAR | ACTUALIZAR-->
                    <?php include_once('view/administrador/modal/mostrarDatosEvento.php'); ?>
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