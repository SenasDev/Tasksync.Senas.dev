document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        locale: 'es',
        firstDay: 1,
        initialView: 'dayGridMonth',
        contentHeight: true,
        height: 'parent',
        fixedWeekCount: false,
        

        header: {
            left: 'title',
            center: '',
            right: 'prev,next,dayGridMonth,timeGridWeek,timeGridDay'
        },
        
        views: {
            dayGridMonth: { // para la vista de mes
                titleFormat: { year: 'numeric', month: 'short' }
            },
            timeGridDay: { // para la vista de día
                titleFormat: { year: 'numeric', month: 'short', day: 'numeric', weekday: 'long' },
                slotDuration: '00:30:00', // Intervalos de 1 hora
                slotLabelInterval: '01:00:00',
                allDaySlot: false, // Mostrar una fila para eventos de todo el día
                scrollTime: '06:55:00'


            },
            timeGridWeek: { // para la vista de semana
                titleFormat: { year: 'numeric' },
                slotDuration: '00:30:00', // Intervalos de 1 hora
                allDaySlot: false, // Mostrar una fila para eventos de todo el día
                slotLabelInterval: '01:00:00', //mostrar horas cada hora
                scrollTime: '06:55:00'   
            },
             
            
        },
        navLinks: true, // clic en los nombres de los días/semanas para navegar por las vistas
        businessHours: {
            // Definir días laborales
            daysOfWeek: [1, 2, 3, 4, 5], // Lunes a Viernes
            startTime: '07:00', // Hora de inicio laboral (06:00 a.m.)
            endTime: '18:00' // Hora de fin laboral (18:00 p.m.)
        },
         // muestra las horas de trabajo
        editable: true,
        events: [
            // agregar tus eventos
            {
                title: 'Evento de prueba',
                start: '2024-04-10T10:00:00',
                end: '2024-04-10T13:00:00'
            },
            {
                title: 'Evento de prueba',
                start: '2024-04-10T13:00:00',
                end: '2024-04-10T14:00:00'
            }
            
        ]
    });

    calendar.render();
});
