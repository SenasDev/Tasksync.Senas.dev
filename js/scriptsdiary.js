document.addEventListener('DOMContentLoaded', function () {
    let modal = document.getElementById('addEventModal');
    let buttonPlus = document.getElementById('buttonPlus');
    let closeModal = document.querySelector('.close');
    let editModal = document.getElementById('editEventModal');
    let closeEditModal = document.querySelector('#editEventModal .close');
    let editModalTitle = document.getElementById('editTitle');
    let editModalDescription = document.getElementById('editDescription');
    let editModalLabel = document.getElementById('editLabel');
    let editModalDate = document.getElementById('editDate');
    let editModalTime = document.getElementById('editTime');
    let taskId = document.getElementById('taskId');
    

    let calendar; 

    buttonPlus.addEventListener('click', function () {
        modal.style.display = 'block';
        setCurrentDateTime()
    });

    closeModal.addEventListener('click', function () {
        modal.style.display = 'none';
    });

    closeEditModal.addEventListener('click', function () {
        editModal.style.display = 'none';
    });

    function adjustCalendarSize() {
        var width = window.innerWidth;
        var height = window.innerHeight;
        var contentHeight = 750;

        // iPhone 6/7/8 - 375x667
        if (width <= 376) {
            contentHeight = 400;
        }
        
        // iPhone 12 Pro - 390x844
        else if (width <= 390) {
            contentHeight = 500;
        }
        // Standard Android
        else if (width <= 512 && height <= 950) {
            contentHeight = 550; // 
        }
        
        else if (width <= 1925) {
            contentHeight = 500;
        }
        calendar.setOption('contentHeight', contentHeight);
        calendar.updateSize();
    }

    $.ajax({
        url: 'server/getuserbyid.php',
        type: 'GET',
        dataType: 'json',
        success: function (userData) {
            let eventos = userData.map(function (evento) {
                return {
                    id: evento.ID,
                    title: evento.Title,
                    start: evento.start,
                    color: evento.Label === 'trabajo' ? 'var(--event-work)' :
                        evento.Label === 'deporte' ? 'var(--event-sport)' :
                            evento.Label === 'ocio' ? 'var(--event-leisure)' :
                                'var(--event-other)',
                    description: evento.Description,
                    label: evento.Label
                };
            });

            var calendarEl = document.getElementById('calendario');
            calendar = new FullCalendar.Calendar(calendarEl, {
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
                handleWindowResize: true,
                windowResize: adjustCalendarSize,
                events: eventos,
                dateClick: function (info) {
                    setCurrentDateTime()
                    modal.style.display = 'block';
                    document.getElementById('date').value = new Date(info.dateStr).toISOString().split('T')[0];
                    // Obtener la hora actual
                }
                ,
                eventClick: function (info) {
                    let event = info.event;
                    taskId.value = event.id;
                    editModalTitle.value = event.title;
                    editModalDescription.value = event.extendedProps.description || '';
                    editModalLabel.value = event.extendedProps.label || '';
                    editModalDate.value = new Date(event.start).toISOString().split('T')[0];
                    editModalTime.value = new Date(event.start).toTimeString().split(':')[0] + ':' + new Date(event.start).toTimeString().split(':')[1];
                    editModal.style.display = 'block';
                    info.jsEvent.preventDefault();
                }
            });

            calendar.render();
            adjustCalendarSize(); // Now adjustCalendarSize will be called after the calendar is initialized
        },
        error: function (xhr, status, error) {
            console.error('Error al obtener datos del usuario:', error);
        }
    });
    function setCurrentDateTime() {
        let now = new Date();
        
        // Formatear la fecha en formato YYYY-MM-DD
        let formattedDate = now.toISOString().split('T')[0];
        
        // Formatear la hora en formato HH:MM
        let currentHours = now.getHours().toString().padStart(2, '0');
        let currentMinutes = now.getMinutes().toString().padStart(2, '0');
        let formattedTime = `${currentHours}:${currentMinutes}`;
        
        // Asignar los valores a los campos del modal
        document.getElementById('date').value = formattedDate;
        document.getElementById('time').value = formattedTime;
    }
});




