document.addEventListener('DOMContentLoaded', function() {
        let nombre_medico = document.getElementById('txt_nombre_medico').value;
        let txt_mes = document.getElementById('txt_mes').value;
        let txt_estado = document.getElementById('txt_estado').value;

        var calendarEl = document.getElementById('calendarAdministrador');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locale : 'es',
          initialDate : txt_mes,  //PARA ESTABLECER UN MES POR DEFECTO
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
          },
          
          eventTimeFormat: { // like '14:30:00'
            hour: 'numeric', //2-digit
            minute: '2-digit',
            //second: '2-digit',
            meridiem: false
          },
          
          editable: true,    //para que aparacezca la mano en el cintillo
          selectable: true,

          
          //URL DE HORARIOS REGISTRADOS POR LOS MEDICOS Y SE ENLAZA CON LA PLANTILLA "view/administrador/calendario/calendario.php"
          events: "http://172.16.126.79/sishorarios/index.php?ruta=getAllEventMedicoBYId&txt_nombre_medico="+nombre_medico+"&txt_mes="+txt_mes+"&txt_estado="+txt_estado,
          

          //MOSTRANDO EL MODAL CON LOS DATOS DE LA BD PARA LA ACTUALIZACION
          eventClick: function (info) {
            let eventCalendar = info.event;            //CAMPOS EN INGLES
            let eventComun = info.event.extendedProps; //CAMPOS EN ESPAÑOL
            let fechaStart = moment(eventCalendar.start).format("YYYY-MM-DD HH:mm:ss");
            let nuevaFechaStart = fechaStart.replace(" ", "T") //DAR EL FORMATO DE FECHA DATETIME
            let fechaEnd = moment(eventCalendar.end).format("YYYY-MM-DD HH:mm:ss");
            let nuevaFechaEnd = fechaEnd.replace(" ", "T") //DAR EL FORMATO DE FECHA DATETIME
            $('#txt_id').val(eventCalendar.id);
            $('#txt_titulo').val(eventCalendar.title);
            $('#txt_descripcion').val(eventComun.descripcion);
            $('#txt_id_medico').val(eventComun.id_medico);
            $('#txt_medico').val(eventComun.medico);
            $('#txt_color').val(eventCalendar.backgroundColor);
            $('#txt_color_texto').val(eventCalendar.textColor);
            $('#txt_fecha_inicio').val(nuevaFechaStart);
            $('#txt_fecha_fin').val(nuevaFechaEnd);
            $('#modalEvento').modal('show');
            console.log('id:'+eventCalendar.id);
            console.log('titulo:'+eventCalendar.title);
            console.log('descripcion:'+eventComun.descripcion);
            console.log('id medico:'+eventComun.id_medico);
            console.log('color:'+eventCalendar.backgroundColor);
            console.log('color texto:'+eventCalendar.textColor);
            console.log('fecha start:'+moment(eventCalendar.start).format("DD/MM/YYYY HH:mm:ss"));
            console.log('fecha fin:'+moment(eventCalendar.end).format("DD/MM/YYYY HH:mm:ss"));
            console.log('fecha inicio:'+nuevaFechaStart);
            
          }


        });
        console.log('medico id: '+ nombre_medico);
        console.log('´Mes:' +txt_mes);
        calendar.render();

});