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
                            <table id="datatable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">MEDICO</th>
                                        <th scope="col">CODIGO</th>
                                        <th scope="col">COMPAÑIA</th>
                                        <th scope="col">CARGO</th>
                                        <th scope="col">ESPECIALIDAD</th>
                                        <th scope="col" class="text-center"><i class='bx bxs-edit-alt bx-tada'></i></th>
                                        <th scope="col" class="text-center"><i class='bx bxs-edit-alt bx-tada'></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dataMedico as $data) : $i = $i + 1; ?>
                                        <tr>
                                            <th scope="row"><?php echo $i ?></th>
                                            <td><?php echo $data->nombre_medico ?></td>
                                            <td><?php echo $data->codigo_medico ?></td>
                                            <td><?php echo $data->nombre_compania ?></td>
                                            <td><?php echo $data->nombre_cargo ?></td>
                                            <td><?php echo $data->nombre_especialidad ?></td>
                                            <td>
                                                <?php if ($data->id_cargo == 2) : ?>
                                                    <form action="MedicoCargo" method="POST">
                                                        <input type="text" name="txt_nombre_medico_dependiente" id="txt_nombre_medico_dependiente" value="<?php echo $data->nombre_medico ?>" hidden>
                                                        <input type="text" name="txt_id_medico_dependiente" id="txt_id_medico_dependiente" value="<?php echo $data->id_medico ?>" hidden>
                                                        <button class="btn btn-outline-primary btn-user" name="btn-asignar-cargo" id="btn-asignar-cargo">Asignar</button>
                                                    </form>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <form action="dataEspecialidadMedicoEditar" method="POST">
                                                    <input type="text" name="txt_nombre_medico" id="txt_nombre_medico" value="<?php echo $data->nombre_medico ?>" hidden>
                                                    <input type="text" name="id_medico" id="id_medico" value="<?php echo $data->id_medico ?>" hidden>
                                                    <button class="btn btn-outline-danger btn-user" name="btn-editar-especialidad" id="btn-editar-especialidad">Especialidad</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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