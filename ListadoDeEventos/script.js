// -------------------------------------------- CODIGO SIN USO -----------------------------------------------------

// document.getElementById("login-button").addEventListener("click", function() {
//   window.location.href = "../login/login.php";
// });

// function registerEvent(event) {
//   var button = event.target;
//   var confirmed = confirm("¿Estás seguro de registrarte a este evento?");

//   if (confirmed) {
//     button.textContent = "Registrado";
//     button.classList.add("registered");
//     button.disabled = true;

//     var cancelButton = button.parentElement.querySelector(".cancel-button");
//     cancelButton.style.display = "inline-block"; // Mostrar el botón de Cancelar Registro
//   }
// }

// var registerButtons = document.querySelectorAll(".register-button");

// registerButtons.forEach(function(button) {
//   button.addEventListener("click", registerEvent);
// });

// function cancelRegistration(event) {
//   var button = event.target;
//   var confirmed = confirm("¿Estás seguro de cancelar tu registro a este evento?");

//   if (confirmed) {
//     var registerButton = button.parentElement.querySelector(".register-button");
//     registerButton.textContent = "Registrarse a Evento";
//     registerButton.classList.remove("registered");
//     registerButton.disabled = false;
//     button.style.display = "none";
//   }
// }

// var cancelButtons = document.querySelectorAll(".cancel-button");

// cancelButtons.forEach(function(button) {
//   button.addEventListener("click", cancelRegistration);
// });







// // Obtener referencia al botón "Agregar Evento" y al formulario modal button
// var addButton = document.getElementById("add-event-button");
// var modal = document.getElementById("add-event-modal");



// // Agregar evento de clic al botón "Agregar Evento"
// addButton.addEventListener("click", function() {
//   // Mostrar el formulario modal al hacer clic en el botón
//   modal.style.display = "block";
// });

// // Obtener referencia al botón de cierre del formulario modal
// var closeButton = document.getElementById("close-modal-button");

// // Agregar evento de clic al botón de cierre
// closeButton.addEventListener("click", function() {
//   // Ocultar el formulario modal al hacer clic en el botón de cierre
//   modal.style.display = "none";
// });




// // document.addEventListener("DOMContentLoaded", function() {
// //   const addEventButton = document.getElementById('add-event-button');
// //   const addEventModal = document.getElementById('add-event-modal');
// //   const closeModalButton = document.getElementById('close-modal-button');

// //   // Función para abrir el modal
// //   function openModal() {
// //     addEventModal.style.display = 'block';
// //   }

// //   // Función para cerrar el modal
// //   function closeModal() {
// //     addEventModal.style.display = 'none';
// //   }

// //   // Asignar los manejadores de eventos
// //   addEventButton.addEventListener('click', openModal);
// //   closeModalButton.addEventListener('click', closeModal);
// // });


// // // Obtener referencia al botón "Agregar Evento" y al formulario modal
// // var addButton = document.getElementById("add-event-button");
// // var modal = document.getElementById("add-event-modal");

// // // Agregar evento de clic al botón "Agregar Evento"
// // addButton.addEventListener("click", function() {
// //   // Mostrar el formulario modal al hacer clic en el botón
// //   modal.style.display = "block";
// // });

// // // Obtener referencia al botón de cierre del formulario modal
// // var closeButton = document.getElementById("close-modal-button");

// // // Agregar evento de clic al botón de cierre
// // closeButton.addEventListener("click", function() {
// //   // Ocultar el formulario modal al hacer clic en el botón de cierre
// //   modal.style.display = "none";
// // });








// function mostrarMensajeInscripcion() {
//   // Crear el elemento del mensaje
//   var mensaje = document.createElement("div");
//   mensaje.textContent = "Usuario inscrito correctamente";
//   mensaje.classList.add("mensaje-inscripcion");

//   // Agregar el mensaje al body
//   document.body.appendChild(mensaje);

//   // Desaparecer el mensaje después de 3 segundos
//   setTimeout(function() {
//     mensaje.style.display = "none";
//   }, 3000);
// }


//   // Función para mostrar el pop-up de error
//   function showErrorPopup(message) {
//     document.getElementById("error-message").textContent = message;
//     document.getElementById("error-popup").style.display = "block";
//   }

//   // Evento para cerrar el pop-up de error
//   document.getElementById("close-error-popup").addEventListener("click", function() {
//     document.getElementById("error-popup").style.display = "none";
//   });


//   function redirectToLogin() {
//     window.location.href = '../login/login.php';
//   }


