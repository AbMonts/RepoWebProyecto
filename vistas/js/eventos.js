function showMessage(message) {
    var messageElement = document.createElement('div');
    messageElement.textContent = message;
    messageElement.classList.add('alert', 'alert-info');
    document.body.appendChild(messageElement);
    setTimeout(function() {
      messageElement.remove();
    }, 3000); // Remover el mensaje después de 3 segundos
  }
  
  function modificarEvento(id, titulo, descripcion, fechainicio, fechafin) {
      const modificarEventoIdInput = document.getElementById('modificarEventoId');
      const modificarTituloInput = document.getElementById('modificarTitulo');
      const modificarDescripcionInput = document.getElementById('modificarDescripcion');
      const modificarFechaInicioInput = document.getElementById('modificarFechaInicio');
      const modificarFechaFinInput = document.getElementById('modificarFechaFin');
      const idUsuarioInput = document.getElementById('idUsuario');
  
      modificarEventoIdInput.value = id;
      modificarTituloInput.value = titulo;
      modificarDescripcionInput.value = descripcion;
      modificarFechaInicioInput.value = fechainicio;
      modificarFechaFinInput.value = fechafin;
      idUsuarioInput.value = "<?php echo $idUsuario; ?>";
  
      const modificarEventoModal = new bootstrap.Modal(document.getElementById('editModal'));
      modificarEventoModal.show();
  }
  
  document.querySelectorAll('.list-group-item').forEach(item => {
      item.addEventListener('click', event => {
          const id = item.getAttribute('data-id');
          const titulo = item.getAttribute('data-titulo');
          const descripcion = item.getAttribute('data-descripcion');
          const fechainicio = item.getAttribute('data-fechainicio');
          const fechafin = item.getAttribute('data-fechafin');
          modificarEvento(id, titulo, descripcion, fechainicio, fechafin);
      });
  });
  
  function confirmarEliminar() {
      const modificarEventoIdInput = document.getElementById('modificarEventoId').value;
      const eliminarEventoIdInput = document.getElementById('eliminarEventoId');
      eliminarEventoIdInput.value = modificarEventoIdInput;
      
      const confirmarEliminarModal = new bootstrap.Modal(document.getElementById('confirmarEliminarModal'));
      confirmarEliminarModal.show();
  }
  
  function cerrarModal(modalId) {
      const modal = new bootstrap.Modal(document.getElementById(modalId));
      modal.hide();
  }
  
  document.getElementById('formEliminarEvento').addEventListener('submit', function(event) {
      cerrarModal('editModal');
      cerrarModal('confirmarEliminarModal');
  });
  
  function validarAgregarEvento() {
      const titulo = document.getElementById('titulo').value.trim();
      const descripcion = document.getElementById('descripcion').value.trim();
      const fechainicio = document.getElementById('fechainicio').value;
      const fechafin = document.getElementById('fechafin').value;
  
      if (!titulo || !descripcion || !fechainicio || !fechafin) {
          showMessage('Todos los campos son obligatorios');
          return false;
      }
  
      if (fechainicio.getTime() >= fechafin.getTime() || fechainicio.getTime() < fechaActual.getTime()) {
        showMessage('La fecha de inicio debe ser anterior a la fecha de fin y posterior a la fecha actual');
        return false;
    }
  
      return true;
  }
  
  function validarModificarEvento() {
      const titulo = document.getElementById('modificarTitulo').value.trim();
      const descripcion = document.getElementById('modificarDescripcion').value.trim();
      const fechainicio = document.getElementById('modificarFechaInicio').value;
      const fechafin = document.getElementById('modificarFechaFin').value;
  
      if (!titulo || !descripcion || !fechainicio || !fechafin) {
          showMessage('Todos los campos son obligatorios');
          return false;
      }
  
      if (new Date(fechainicio) >= new Date(fechafin)) {
          showMessage('La fecha de inicio debe ser anterior a la fecha de fin');
          return false;
      }
  
      return true;
  }
  