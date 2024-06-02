document.addEventListener('DOMContentLoaded', (event) => {
  new Sortable(document.getElementById('notasContainer'), {
    animation: 150,
    ghostClass: 'bg-light'
  });
});

function showMessage(message) {
  var messageContainer = document.createElement('span');
  messageContainer.classList.add('position-absolute', 'top-0', 'start-50', 'translate-middle-x');
  
  var messageElement = document.createElement('span');
  messageElement.textContent = message;
  messageElement.classList.add('alert', 'alert-info');
  
  var closeButton = document.createElement('button');
  closeButton.innerHTML = '&times;';
  closeButton.classList.add('btn-close');
  closeButton.addEventListener('click', function() {
    messageContainer.remove();
  });
  
  messageContainer.appendChild(messageElement);
  messageContainer.appendChild(closeButton);
  
  document.body.appendChild(messageContainer);
  
  setTimeout(function() {
      messageContainer.remove();
  }, 3000); // Remover el mensaje después de 3 segundos
}

function confirmarEliminarNota(id) {
  const eliminarNotaIdInput = document.getElementById('eliminarNotaId');
  eliminarNotaIdInput.value = id;
  const confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
  confirmarEliminarModal.show();
  // Redirigir a la misma página después de confirmar la eliminación
  confirmarEliminarModal.addEventListener('hide.bs.modal', function () {
      window.location.href = window.location.href;
  });
}

function modificarNota(id, titulo, contenido) {
  const modificarNotaIdInput = document.getElementById('modificarNotaId');
  const modificarTituloInput = document.getElementById('modificarTitulo');
  const modificarContenidoInput = document.getElementById('modificarContenido');

  modificarNotaIdInput.value = id;
  modificarTituloInput.value = titulo;
  modificarContenidoInput.value = contenido;

  const modificarNotaModal = new bootstrap.Modal(document.getElementById('modificarNotaModal'));
  modificarNotaModal.show();
  // Recargar la página después de modificar la nota
  modificarNotaModal.addEventListener('hide.bs.modal', function () {
      window.location.reload();
  });
}

// Validación del formulario de agregar nota
document.getElementById('formAgregarNota').addEventListener('submit', function(event) {
  const titulo = document.getElementById('titulo').value;
  const contenido = document.getElementById('contenido').value;

  if (!titulo.trim()) {
      showMessage('El título es requerido.');
      event.preventDefault();
  } else if (!contenido.trim()) {
      showMessage('El contenido es requerido.');
      event.preventDefault();
  } else if (titulo.length > 255) {
      showMessage('El título no puede exceder los 255 caracteres.');
      event.preventDefault();
  } else if (contenido.length > 1000) {
      showMessage('El contenido no puede exceder los 1000 caracteres.');
      event.preventDefault();
  }
});

// Validación del formulario de modificar nota
document.getElementById('formModificarNota').addEventListener('submit', function(event) {
  const titulo = document.getElementById('modificarTitulo').value;
  const contenido = document.getElementById('modificarContenido').value;

  if (!titulo.trim()) {
      showMessage('El título es requerido.');
      event.preventDefault();
  } else if (!contenido.trim()) {
      showMessage('El contenido es requerido.');
      event.preventDefault();
  } else if (titulo.length > 255) {
      showMessage('El título no puede exceder los 255 caracteres.');
      event.preventDefault();
  } else if (contenido.length > 1000) {
      showMessage('El contenido no puede exceder los 1000 caracteres.');
      event.preventDefault();
  }
});
