document.addEventListener('DOMContentLoaded', (event) => {
  new Sortable(document.getElementById('notasContainer'), {
    animation: 150,
    ghostClass: 'bg-light'
  });
});

function showMessage(message) {
  var messageElement = document.createElement('div');
  messageElement.textContent = message;
  messageElement.classList.add('alert', 'alert-info');
  document.body.appendChild(messageElement);
  setTimeout(function() {
      messageElement.remove();
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

  if (!titulo) {
      showMessage('El título es requerido.');
      event.preventDefault();
  } else if (contenido.length < 1) {
      showMessage('El contenido debe tener al menos 1 caracter.');
      event.preventDefault();
  }
});

// Validación del formulario de modificar nota
document.getElementById('formModificarNota').addEventListener('submit', function(event) {
  const titulo = document.getElementById('modificarTitulo').value;
  const contenido = document.getElementById('modificarContenido').value;

  if (!titulo) {
      showMessage('El título es requerido.');
      event.preventDefault();
  } else if (contenido.length < 1) {
      showMessage('El contenido debe tener al menos 1 caracter.');
      event.preventDefault();
  }
});
