<?php include_once('view/template/head.php') ?>

<!-- Sidebar -->
<?php include_once('view/template/navGuardias.php'); ?>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Topbar -->
       
        <!-- End of Topbar -->


        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo $titulo ?></h1>
                <!--helpers verCalendario-->

            </div>
            <!-- Content Row -->
            <div class="row">
                <div class="col-md-12 mx-auto">
                    <!--Nombre de mi calendario-->
                    <div class="card">
                        <div class="card-body">
                            <!--Nombre de mi calendario-->
                            <input type="text" name="txt_id_especialidad" id="txt_id_especialidad" value="<?php echo $txt_id_especialidad ?>" hidden>
                            <input type="text" name="txt_mes_especialidad" id="txt_mes_especialidad" value="<?php echo $mes ?>" hidden>
                            <div id='calendarGuardia' class="calendar"></div>

                            <?php include_once('view/guardias/modalGuardia/mostrarDatosEvento.php') ?>
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