// Obtenemos todas las imágenes
const images = document.querySelectorAll('/assets/images');

// Función para cambiar la imagen activa
function changeImage() {
  // Buscamos la imagen activa
  const activeImage = document.querySelector('.image.active');
  
  // Removemos la clase "active" de la imagen actual
  activeImage.classList.remove('active');
  
  // Buscamos la siguiente imagen
  let nextImage = activeImage.nextElementSibling;
  
  // Si no hay siguiente imagen, volvemos a la primera imagen
  if (!nextImage) {
    nextImage = images[0];
  }
  
  // Agregamos la clase "active" a la siguiente imagen
  nextImage.classList.add('active');
}

// Cambiar la imagen cada 7 segundos
setInterval(changeImage, 7000);
