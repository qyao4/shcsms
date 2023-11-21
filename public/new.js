document.addEventListener("DOMContentLoaded", function(){
  CKEDITOR.replace('description');
  const form = document.getElementById('newVehicleForm');
  
  form.addEventListener('submit', function(event) {
    event.preventDefault();
    saveNew();
  });

  function saveNew(){
    let formData = new FormData(form);
    formData.append('action', 'process');
    formData.append('command', 'Create');

    let description = CKEDITOR.instances.description.getData();
    formData.delete('description');
    formData.append('description',description);

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