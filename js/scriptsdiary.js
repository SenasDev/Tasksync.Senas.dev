document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendario');

    let modal = document.getElementById('addEventModal');
    let buttonPlus = document.getElementById('buttonPlus'); // El segundo botón para abrir el modal

    let closeModal = document.querySelector('.close');

    let editModal = document.getElementById('editEventModal');
    let closeEditModal = document.querySelector('#editEventModal .close');

    let editModalTitle = document.getElementById('editTitle');
    let editModalDescription = document.getElementById('editDescription');
    let editModalLabel = document.getElementById('editLabel');
    let editModalDate = document.getElementById('editDate');
    let editModalTime = document.getElementById('editTime');

    let taskId = document.getElementById('taskId');

    // Eventos para abrir el modal
    buttonPlus.addEventListener('click', function () {
        modal.style.display = 'block'; // Abrir modal al clickear el botón plus
    });

    // Eventos para cerrar los modales
    closeModal.addEventListener('click', function () {
        modal.style.display = 'none'; // Cerrar el modal principal
    });

    closeEditModal.addEventListener('click', function () {
        editModal.style.display = 'none'; // Cerrar el modal de editar
    });

    // Cargar datos del usuario desde PHP
    $.ajax({
        url: 'server/getuserbyid.php',
        type: 'GET',
        dataType: 'json',
        success: function (userData) {
            var eventos = userData.map(function (evento) {
                var color = '';
                switch (evento.Label) {
                    case 'trabajo': color = 'var(--event-work)'; break;
                    case 'deporte': color = 'var(--event-sport)'; break;
                    case 'ocio': color = 'var(--event-leisure)'; break;
                    case 'otro': color = 'var(--event-other)'; break;
                    default: color = 'var(--event-other)';
                }
                return {
                    id: evento.ID,
                    title: evento.Title,
                    start: evento.start,
                    color: color,
                    description: evento.Description,
                    label: evento.Label
                };
            });

            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                plugins: ['interaction', 'dayGrid', 'timeGrid', 'list'],
                locale: 'es',
                firstDay: 1,
                initialView: 'dayGridMonth',
                contentHeight: 'auto',
                header: {
                    left: 'title',
                    center: '',
                    right: 'prev,next,dayGridMonth,timeGridWeek'
                },
                handleWindowResize: true, // Habilita el manejo automático del redimensionamiento de la ventana
                windowResize: function (view) {
                    // Ajusta el contentHeight basado en el tamaño actual de la ventana
                    if (window.innerWidth < 768) {
                        calendar.setOption('contentHeight', 500);
                    } else if (window.innerWidth >= 768 && window.innerWidth < 1920) {
                        calendar.setOption('contentHeight', 550);
                    } else {
                        calendar.setOption('contentHeight', 650);
                    }
                    calendar.updateSize(); // Forzar al calendario a actualizar su tamaño
                },
                events: eventos,
                dateClick: function (info) {
                    document.getElementById('date').value = new Date(info.dateStr).toISOString().split('T')[0];
                    document.getElementById('time').value = info.view.type === 'timeGridWeek' && !info.allDay ? info.dateStr.split('T')[1].substring(0, 5) : '';
                    modal.style.display = 'block'; // Abrir modal al clickear en una fecha
                },
                eventClick: function (info) {
                    let event = info.event;
                    taskId.value = event.id;
                    editModalTitle.value = event.title;
                    editModalDescription.value = event.extendedProps.description || '';
                    editModalLabel.value = event.extendedProps.label || '';
                    editModalDate.value = new Date(event.start).toISOString().split('T')[0];
                    editModalTime.value = new Date(event.start).toTimeString().split(':')[0] + ':' + new Date(event.start).toTimeString().split(':')[1];
                    editModal.style.display = 'block'; // Abrir modal de editar al clickear un evento
                    info.jsEvent.preventDefault();
                }
            });

            calendar.render();
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener datos del usuario:', error);
        }
    });
});



