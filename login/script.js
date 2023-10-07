// Obtener referencias a los elementos del formulario
const loginForm = document.getElementById('login-form');
const registerForm = document.getElementById('register-form');
const registerToggleButton = document.getElementById('register-toggle-button');

// Agregar evento de clic al botón "Registrarse"
registerToggleButton.addEventListener('click', () => {
  // Alternar la visibilidad del formulario de inicio de sesión y registro
  loginForm.style.display = 'none';
  registerForm.style.display = 'block';
});