document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('newVehicleForm');
  
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    saveNew();
  });

  function saveNew(){
    let formData = new FormData(form);
    formData.append('action', 'process');
    formData.append('command', 'Create');

    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          alert('Creating New Data Succeeded!');
          window.location.href = 'admin.php';

        }
        else{
          alert('Creating New Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }

});