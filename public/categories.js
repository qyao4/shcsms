document.addEventListener("DOMContentLoaded", function(){

  const form = document.getElementById('categoryForm');
  let newItemCount = 0;

  document.getElementById('addRow').addEventListener('click', function() {
      var tableBody = document.getElementById('categoryTableBody');
      var newRow = tableBody.insertRow();
      var cell1 = newRow.insertCell(0);
      var cell2 = newRow.insertCell(1);
      var cell3 = newRow.insertCell(2);

      let newId = createCategroryId();
      cell1.innerHTML = newId;
      cell2.innerHTML = "<input type='text' edit_type='new' class='form-control' name=" + newId + ">";
      cell3.innerHTML = "<button type='button' class='btn btn-danger'>Delete</button>";
      cell3.addEventListener('click', function() {
        deleteRow(this);
      });
  });

  function deleteRow(btn) {
      var row = btn.parentNode;
      row.parentNode.removeChild(row);
  }

  function createCategroryId(){
    return 'NEW'+ (++newItemCount);
  }

  function getUpdates(){
    let updates = {};
    let inputs = document.querySelectorAll('#categoryTableBody input[edit_type="update"]');
    inputs.forEach(function(input) {
        if (input.value !== input.getAttribute('org_value')) {
            updates[input.name] = input.value;
        }
    });
    return updates;
  }

  function getCreates(){
    let news = {};
    let inputs = document.querySelectorAll('#categoryTableBody input[edit_type="new"]');
    inputs.forEach(function(input) {
      if(input.value)
      news[input.name] = input.value;
    });
    return news;
  }

  form.addEventListener('submit', function(event) {
    event.preventDefault();
    saveCategories();
  });

  function saveCategories(){
    let formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
      console.log(key, value);
    }
    
    let updates = getUpdates();
    let creates = getCreates();

    formData = new FormData();
    formData.append('updates', JSON.stringify(updates));
    formData.append('creates', JSON.stringify(creates));

    // if(Object.keys(updates).length > 0)
    for (let [key, value] of formData.entries()) {
      console.log(key, value);
    }

    formData.append('action', 'categories');
    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          alert('Saving Categories Data Succeeded!');
          window.location.reload();
        }
        else{
          alert('Saving Categories Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });

  }

});