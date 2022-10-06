<!-- Page-header end -->
<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#EditarCompanias<?php echo $data->id_usuario ?>">
    <i class='bx bx-edit bx-tada'></i>
</button>

<!--LLAVE DEL MODAL-->
<div class="modal fade" id="EditarCompanias<?php echo $data->id_usuario ?>" tabindex="-1" aria-labelledby="EditarCompanias" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="EditarCompanias">CODIGO USUARIO: <?php echo $data->id_usuario ?></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <form action="ActivarUsuarioMedico" id="" method="POST">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-control-label">MEDICO</label>
                                    <input type="text" name="txt_id_usuario" id="txt_id_usuario" value="<?php echo $data->id_usuario ?>" hidden>
                                    <input type="text" name="txt_nombre_medico" id="txt_nombre_medico" value="<?php echo $data->nombre_medico ?>" class="form-control">
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto">
                                <button type="submit" class="btn btn-outline-primary w-100" name="btn_activar_usuario_medico" id="<?php echo $data->id_usuario ?>">Activar Usuario</button>
                            </div>
                        </div>
                    </form>
                    <!--end row-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>