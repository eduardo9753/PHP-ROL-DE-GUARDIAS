window.addEventListener('DOMContentLoaded', () => {
    
    $(document).ready( function () {
        $('#datatable').DataTable(); //PARA LA PAGINACION
    } );

    /*PARA UNA SOLA TABLA 1 FORMA
    $('.datatable1').dataTable( {
        "pageLength": 25
    });*/

    /*PARA TODAS LAS TABLA 2 FORMA
    $('#datatable').dataTable( {
        "pageLength": 25
    });*/

    /*3 FORMA EN EL HTML DE LA TABLA
    <table data-page-length='25'>
     ...
    </table>
    */
});
