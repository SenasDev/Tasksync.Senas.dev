document.addEventListener('DOMContentLoaded', function() {
    // Manejador para el formulario de adición
    var addForm = document.getElementById('addEventForm');
    if (addForm) {
        addForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this);
        });
    }
    // Manejador para el formulario de edición
    var editForm = document.getElementById('editEventForm');
    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleFormSubmit(this, e.submitter);
        });
    }
});

function handleFormSubmit(form, submitter) {
    var formData = new FormData(form);
    if (submitter) {
        formData.set('action', submitter.value);
    }
    var actionUrl = form.getAttribute('action') || '/tasksync/server/eventhandler.php';
    var responseDivId = form.id === 'addEventForm' ? 'responseAdd' : 'responseEdit';
    var responseDiv = document.getElementById(responseDivId);

    fetch(actionUrl, {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        responseDiv.innerHTML = data.message;
        if (data.success) {
            responseDiv.classList.add('success-message');
             setTimeout(function() {
                window.location.reload(true);
            }, 2000);
        } else {
            responseDiv.classList.add('error-message');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        responseDiv.innerHTML = 'Error en la operación: ' + error.message;
        responseDiv.classList.add('error-message');
    });
}

