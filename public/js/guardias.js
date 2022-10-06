document.addEventListener('DOMContentLoaded', function() {
    let txt_id_especialidad = document.getElementById('txt_id_especialidad').value;
    let txt_mes_especialidad = document.getElementById('txt_mes_especialidad').value;
  
    var calendarEl = document.getElementById('calendarGuardia');
    var calendar = new FullCalendar.Calendar(calendarEl, {
  
      initialView: 'dayGridMonth',
      locale : 'es',
      initialDate : txt_mes_especialidad,  //PARA ESTABLECER UN MES POR DEFECTO
      headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,listWeek'
      },
      
      
      //editable: true,    //para que aparacezca la mano en el cintillo
      selectable: true,
  
      
      //URL DE HORARIOS REGISTRADOS POR LOS MEDICOS Y SE ENLAZA CON LA PLANTILLA "view/administrador/calendario/calendario.php"
      events: "http://172.16.126.79/sishorarios/index.php?ruta=getAllEventCalendarioPorEspecialidadVisor&txt_id_especialidad="+txt_id_especialidad+"&txt_mes_especialidad="+txt_mes_especialidad,
  
      eventTimeFormat: { // like '14:30:00'
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        meridiem: false
      },
      
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
        $('#txt_medico').val(eventCalendar.title);
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
        console.log('fecha inicio:'+nuevaFechaStart);
        console.log('fecha fin:'+nuevaFechaEnd);
        
        
      }
  
    });
    console.log('especialidad id: '+ txt_id_especialidad);
    console.log('Mes:' +txt_mes_especialidad);
    calendar.render();
  
  });