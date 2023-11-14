document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('VehicleForm');
  const btnUpdate = document.getElementById('Update');
  const btnDelete = document.getElementById('Delete');

  btnUpdate.addEventListener('click',function(event){
    event.preventDefault();
    save('Update');
  })

  btnDelete.addEventListener('click',function(event){
    event.preventDefault();
    save('Delete');
  })

  //Init data
  const params = new URLSearchParams(window.location.search);
  const vehicle_id = params.get('id');
  if(!vehicle_id){
    alert('Init data failed.');
    window.location.href = 'signin_processor.php';
  }
  
  initData();

  function initData(){
    let formData = new FormData(form);
    formData.append('vehicle_id',vehicle_id);
    formData.append('action', 'getVehicle');
    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          document.getElementById('makeSelect').value = data['data']['make'];
          populateModels(data['data']['make']);
          document.getElementById('modelSelect').value = data['data']['model'];
          document.getElementById('category').value = data['data']['category_id'];
          document.getElementById('year').value = data['data']['year'];
          document.getElementById('price').value = data['data']['price'];
          document.getElementById('mileage').value = data['data']['mileage'];
          document.getElementById('exteriorColor').value = data['data']['exterior_color'];
          document.getElementById('description').value = data['data']['description'];
        }
        else{
          alert('Init Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }  

  function save(command){
    let formData = new FormData(form);
    formData.append('action', 'process');
    formData.append('command', command);
    formData.append('vehicle_id',vehicle_id);

    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          if(command == 'Update'){
            alert('Update Data Succeeded!');
          }
          else{
            alert('Delete Data Succeeded!');
            window.location.href = 'admin.php';
          }
          
        }
        else{
          alert('Process Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }

});