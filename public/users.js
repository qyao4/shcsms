document.addEventListener("DOMContentLoaded", function(){

  const form = document.getElementById('userForm');

  document.getElementById('addRow').addEventListener('click', function() {
      let tableBody = document.getElementById('userTableBody');
      let newRow = tableBody.insertRow();
      let cell1 = newRow.insertCell(0);
      cell1.innerHTML = `<input type='text' class='form-control' name='username' value='' required >`;
      let cell2 = newRow.insertCell(1);
      cell2.innerHTML = `<input type='email' class='form-control' name='email' value='' required >`;
      addButtons(newRow);
  });

  initData();

  function initData(){
    let formData = new FormData();
    formData.append('action', 'getUsers');
    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        let tableBody = document.getElementById('userTableBody');
        tableBody.innerHTML = '';
        if(data['result'] == 'succ'){
          data['data'].forEach(user => {
            let row = tableBody.insertRow();
            for (let key in user) {
              if(key == 'user_id')
                row.id = user['user_id'];
              if (user.hasOwnProperty(key) && (key =='username' || key == 'email')) {
                let cell = row.insertCell();
                let type = key=='email' ? 'email':'text';
                cell.innerHTML = `<input type='${type}' class='form-control' name='${key}' value='${user[key]}' required>`;
              }
            }
            addButtons(row);
            
          });
        }
        else{
          alert('Init Data Failed!');
          window.location.href = 'signin_processor.php';
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        //window.location.href = 'signin_processor.php';
    });
  } 

  function addButtons(row){
    let editCell = row.insertCell();
    editCell.style.verticalAlign = 'middle';
    editCell.style.fontSize = '1.5em';

    let editLink = document.createElement('a');
    editLink.innerHTML = 'Update';
    editLink.className = 'table-edit';
    editLink.addEventListener("click",function(){
      saveRow(row);
    })
    editCell.appendChild(editLink);

    let delLink = document.createElement('a');
    delLink.innerHTML = 'Delete';
    delLink.className = 'table-edit';
    delLink.style.marginLeft = '1em';
    delLink.style.color = 'red';
    delLink.addEventListener("click",function(){
      deleteRow(row);
    })
    editCell.appendChild(delLink);
  }

  function saveRow(row){
    console.log('saveRow',row);
    let user_id = row.id ? row.id : '';
    let jsonObject = {
        user_id: user_id,
    };
    let allValid = true;
    let inputs = row.querySelectorAll('input');

    inputs.forEach(input => {
        if (input.reportValidity()) {
            jsonObject[input.name] = input.value;
        } else {
            console.error(`Invalid input: ${input.name}`);
            allValid = false;
        }
    });
    if(!allValid)
      return;

    let formData = new FormData();
    formData.append('data', JSON.stringify(jsonObject));
    formData.append('command', 'Update');
    sentPost(formData);
  }

  function deleteRow(row) {
    console.log('deleteRow',row);
    let user_id = row.id ? row.id : '';
    if(!user_id){
      row.parentNode.removeChild(row);
      return;
    }
    let jsonObject = {
      user_id: user_id,
    };
    let formData = new FormData();
      formData.append('data', JSON.stringify(jsonObject));
      formData.append('command', 'Delete');
      sentPost(formData);
    }

  function sentPost(formData)
  {
    formData.append('action', 'manageUsers');
    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          alert('Saving User Data Succeeded!');
          window.location.reload();
        }
        else{
          alert('Saving User Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }

});