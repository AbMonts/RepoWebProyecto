function validateForm() {
  var tituloInput = document.getElementById('titulo');
  var contenidoInput = document.getElementById('contenido');
  var fechaInicioInput = document.getElementById('fechainicio');
  var fechaFinInput = document.getElementById('fechafin');

  // Validación del campo de título
  if (tituloInput.value.trim().length < 3 || tituloInput.value.trim().length > 50) {
    showMessage("El título debe tener entre 3 y 50 caracteres.");
    return false;
  }

  // Validación del campo de contenido
  if (contenidoInput.value.trim().length < 10) {
    showMessage("El contenido debe tener al menos 10 caracteres.");
    return false;
  }

  // Validación del campo de fecha de inicio y fecha de fin
  var fechaInicio = new Date(fechaInicioInput.value);
  var fechaFin = new Date(fechaFinInput.value);

  if (!fechaInicioInput.value || !fechaFinInput.value) {
    showMessage("Por favor, completa tanto la fecha de inicio como la fecha de fin.");
    return false;
  }

  if (fechaInicio >= fechaFin) {
    showMessage("La fecha de inicio debe ser anterior a la fecha de fin.");
    return false;
  }

  return true;
}

function showMessage(message) {
  var messageElement = document.createElement('div');
  messageElement.textContent = message;
  messageElement.classList.add('alert', 'alert-info');
  document.body.appendChild(messageElement);
  setTimeout(function() {
    messageElement.remove();
  }, 3000); // Remover el mensaje después de 3 segundos
}
