var vehicleContainers = document.querySelectorAll('.vehicle-container');

vehicleContainers.forEach(function(container) {
  container.addEventListener('click', function() {
      var divId = this.getAttribute('data-id');
      
      window.location.href = '/cars?id=' + divId;
  });
});