document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
        locale: 'es', // Establece el locale a español
        firstDay: 1,
        initialView: 'dayGridMonth',
        contentHeight: true,
        height:'parent',
        fixedWeekCount: false,
        
         // Establece el primer día de la semana a lunes
        header: {
            left: 'title',
            center: '',
            right: 'prev,next,dayGridMonth,timeGridWeek,timeGridDay'
        },
        titleFormat: { // especifica cómo se debe mostrar el título del mes
            month: 'short', // nombre completo del mes
            year: 'numeric', // año con cuatro dígitos
            
        },
        navLinks: true, // puede hacer clic en los nombres de los días/semanas para navegar por las vistas
        businessHours: true, // muestra las horas de trabajo
        editable: true,
        events: [
            // Tus eventos aquí
        ]
    });

    calendar.render();
});
