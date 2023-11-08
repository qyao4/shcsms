var vehiclesData = {};

document.addEventListener('DOMContentLoaded', function() {
  fetch('tools/makemodel.json')
    .then(response => response.json())
    .then(data => {
      vehiclesData = data;
      populateMakes(data);
    });

  document.getElementById('makeSelect').addEventListener('change', function() {
    var make = this.value;
    populateModels(make);
  });

  document.getElementById('modelSelect').disabled = true;
});

function populateMakes(data) {
  var makeSelect = document.getElementById('makeSelect');
  for (var make in data) {
    var option = document.createElement('option');
    option.value = make;
    option.textContent = make;
    makeSelect.appendChild(option);
  }
}

function populateModels(make) {
  let modelSelect = document.getElementById('modelSelect');
  modelSelect.innerHTML = ''; 
  let noneOption = document.createElement('option');
  noneOption.value = '';
  noneOption.textContent = 'Select Model';
  modelSelect.appendChild(noneOption);

  if (make && vehiclesData[make]) {
    let models = vehiclesData[make];
    models.forEach(function(model) {
      let option = document.createElement('option');
      option.value = model;
      option.textContent = model;
      modelSelect.appendChild(option);
    });
    modelSelect.disabled = false;
  }
  else
    modelSelect.disabled = true;
}

