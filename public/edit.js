document.addEventListener("DOMContentLoaded", function(){
  CKEDITOR.replace('description');

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
          document.getElementById('makeSelect').value = data['data']['baseinfo']['make'];
          populateModels(data['data']['baseinfo']['make']);
          document.getElementById('modelSelect').value = data['data']['baseinfo']['model'];
          document.getElementById('category').value = data['data']['baseinfo']['category_id'];
          document.getElementById('year').value = data['data']['baseinfo']['year'];
          document.getElementById('price').value = data['data']['baseinfo']['price'];
          document.getElementById('mileage').value = data['data']['baseinfo']['mileage'];
          document.getElementById('exteriorColor').value = data['data']['baseinfo']['exterior_color'];
          document.getElementById('description').value = data['data']['baseinfo']['description'];

          showComments(data['data']['commentinfo']);
        }
        else{
          alert('Init Data Failed!');
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }  

  function showComments(comments){
    let commentsContainer = document.getElementById('commentsContainer');
    commentsContainer.innerHTML = '';
    comments.forEach(function(comment) {
        let commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');

        // Show username & create
        let userInfo = document.createElement('p');
        userInfo.style.cssText = 'font-size: 0.8em; font-style: italic; color: gray;';
        userInfo.textContent = comment.username + ' - ' + comment.create_date;
        commentDiv.appendChild(userInfo);

        // Add content
        let contentDiv = document.createElement('div');
        contentDiv.classList.add('comment-content');
        contentDiv.textContent = comment.content;
        commentDiv.appendChild(contentDiv);

        // Add buttons
        let actionsDiv = document.createElement('div');
        actionsDiv.classList.add('comment-actions');

        // Hide/Show Button
        let toggleButton = document.createElement('button');
        let hors = comment.status === 'S' ? 'Hide' : 'Show';
        toggleButton.textContent = hors
        toggleButton.onclick = function() {
          console.log('click: hide/show');
          let formData = new FormData();
          formData.append('comment_id',comment.comment_id);
          formData.append('command', hors);
          formData.append('status', comment.status === 'S' ? 'H' : 'S');
          processComment(formData);
        };
        actionsDiv.appendChild(toggleButton);

        // Disemvowel Button
        let disemvowelButton = document.createElement('button');
        disemvowelButton.textContent = 'Disemvowel';
        disemvowelButton.onclick = function() {
          console.log('click: Disemvowel');
          let formData = new FormData();
          formData.append('comment_id',comment.comment_id);
          formData.append('command','Disemvowel');
          formData.append('content',disemvowelWithAsterisk(comment.content));
          processComment(formData);
        };
        actionsDiv.appendChild(disemvowelButton);

        // Delete Button
        let deleteButton = document.createElement('button');
        deleteButton.textContent = 'Delete';
        deleteButton.onclick = function() {
          console.log('click: Delete');
          let formData = new FormData();
          formData.append('comment_id',comment.comment_id);
          formData.append('command', 'Delete');
          processComment(formData);
        };
        actionsDiv.appendChild(deleteButton);
        
        commentDiv.appendChild(actionsDiv);
        commentsContainer.appendChild(commentDiv);
    });
  }

  function processComment(formData){
    formData.append('action', 'updateComment');
    formData.append('vehicle_id', vehicle_id);
    fetch('request.php',{
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          alert('Comment processing successful.')
          showComments(data['data']['commentinfo']);
        }
        else{
          alert('Comment processing failed.');
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

  function disemvowelWithAsterisk(str) {
    return str.replace(/[aeiouAEIOU]/g, '*');
  }


});