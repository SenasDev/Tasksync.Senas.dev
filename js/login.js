$(document).ready(function() {
  $('#formRegistro').on('submit', function(e) {
      e.preventDefault(); // Evitar el envío del formulario de manera tradicional
      $.ajax({
          type: "POST",
          url: "server/register.php", // Asegúrate de que esta es la ruta correcta al archivo PHP desde index.php
          data: $(this).serialize(), // Serializa los datos del formulario
          success: function(response) {
              // Aquí manejas la respuesta del servidor
              if (response.includes("Usuario registrado con éxito")) {
                  // Si el registro es exitoso, muestra una alerta y redirige
                  alert(response);
                  window.location.href = 'index.php'; // Redirige a index.php
              } else {
                  // Si hay un error, muestra una alerta con el mensaje
                  alert(response);
              }
          }
      });
  });
});
