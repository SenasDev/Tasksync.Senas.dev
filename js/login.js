$(document).ready(function() {
  $('#formRegistro').on('submit', function(e) {
      e.preventDefault(); 
      $.ajax({
          type: "POST",
          url: "server/register.php",
          data: $(this).serialize(),
          success: function(response) {
              if (response.includes("Usuario registrado con éxito")) {
                  alert(response);
                  window.location.href = 'index.php';
              } else {
                  alert(response);
              }
          }
      });
  });
});
