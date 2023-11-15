let vehicleContainers = document.querySelectorAll('.vehicle-container');

vehicleContainers.forEach(function (container) {
  container.addEventListener('click', function () {
    let divId = this.getAttribute('data-id');

    window.location.href = '/vehicle?id=' + divId;
  });
});
