document.addEventListener('DOMContentLoaded', function() {
  function redirectToEventList() {
    window.location.href = 'listaEventos.php'; // Reemplaza la URL con la página que desees
  }

  var loginButton = document.getElementById("login-button");
  if (loginButton) {
    loginButton.addEventListener("click", function() {
      window.location.href = "../login/login.php";
    });
  }

  function registerEvent(event) {
    var button = event.target;
    var confirmed = confirm("¿Estás seguro de registrarte a este evento?");

    if (confirmed) {
      button.textContent = "Registrado";
      button.classList.add("registered");
      button.disabled = true;

      var cancelButton = button.parentElement.querySelector(".cancel-button");
      cancelButton.style.display = "inline-block"; // Mostrar el botón de Cancelar Registro
    }
  }

  var registerButtons = document.querySelectorAll(".register-button");

  registerButtons.forEach(function(button) {
    button.addEventListener("click", registerEvent);
  });

  function cancelRegistration(event) {
    var button = event.target;
    var confirmed = confirm("¿Estás seguro de cancelar tu registro a este evento?");

    if (confirmed) {
      var registerButton = button.parentElement.querySelector(".register-button");
      registerButton.textContent = "Registrarse a Evento";
      registerButton.classList.remove("registered");
      registerButton.disabled = false;
      button.style.display = "none";
    }
  }

  var cancelButtons = document.querySelectorAll(".cancel-button");

  cancelButtons.forEach(function(button) {
    button.addEventListener("click", cancelRegistration);
  });

  function mostrarMensajeInscripcion() {
    var mensaje = document.createElement("div");
    mensaje.textContent = "Usuario inscrito correctamente";
    mensaje.classList.add("mensaje-inscripcion");

    document.body.appendChild(mensaje);

    setTimeout(function() {
      mensaje.style.display = "none";
    }, 3000);
  }

  function showErrorPopup(message) {
    document.getElementById("error-message").textContent = message;
    document.getElementById("error-popup").style.display = "block";
  }

  document.getElementById("close-error-popup").addEventListener("click", function() {
    document.getElementById("error-popup").style.display = "none";
  });

  function redirectToLogin() {
    window.location.href = '../login/login.php';
  }
});
