document.addEventListener("DOMContentLoaded", function(){
  CKEDITOR.replace('description');

  const form = document.getElementById('VehicleForm');
  const btnUpdate = document.getElementById('Update');
  const btnDelete = document.getElementById('Delete');
  const container = document.getElementById('imagePreviewContainer');
  let deleteImageIds = [];

  btnUpdate.addEventListener('click',function(event){
    event.preventDefault();
    save('Update');
  })

  btnDelete.addEventListener('click',function(event){
    event.preventDefault();
    save('Delete');
  })

  //Init data
  // const params = new URLSearchParams(window.location.search);
  // const vehicle_id = params.get('id');
  const pathParts = window.location.pathname.split('/');
  const vehicle_id = pathParts[pathParts.length - 3];  
  const slug = pathParts[pathParts.length - 2];
  console.log('vehicle_id:',vehicle_id);
  console.log('slug:',slug);
  if(!vehicle_id || !slug){
    alert('Init data failed.');
    window.location.href = 'signin_processor.php';
  }
  
  initData();

  function initData(){
    let formData = new FormData(form);
    formData.append('vehicle_id',vehicle_id);
    formData.append('slug',slug);
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
          // document.getElementById('description').value = data['data']['baseinfo']['description'];
          // CKEDITOR.instances.description.setData(data['data']['baseinfo']['description']);

          loadImages(data['data']['imageinfo']);
          
          if (CKEDITOR.instances.description) {
            if (CKEDITOR.instances.description.status == 'ready') {
              // let decodedHtml = htmlDecode(data['data']['baseinfo']['description']);
              CKEDITOR.instances.description.setData(data['data']['baseinfo']['description']);
              console.log('CKEDITOR ready.');
            } else {
                CKEDITOR.instances.description.on('instanceReady', function() {
                  // let decodedHtml = htmlDecode(data['data']['baseinfo']['description']);
                  CKEDITOR.instances.description.setData(data['data']['baseinfo']['description']);
                  console.log('CKEDITOR ready.');
                });
                console.error('CKEDITOR not ready.');
            }
        }
        document.getElementById('slug').value = data['data']['baseinfo']['slug'];

          showComments(data['data']['commentinfo']);
        }
        else{
          alert('Init Data Failed!');
          window.location.href = 'signin_processor.php';
        }
    })
    .catch((error) => {
        console.error('Error:', error);
        window.location.href = 'signin_processor.php';
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

    if(deleteImageIds.length>0){
      deleteImageIds.forEach(function(id) {
        formData.append('deleteImageIds[]', id);
      });
    }

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
            // let slugText = data['data']['slug'];
            window.location.reload();
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

  function loadImages(images){
    let baseurl = getBaseURL();
    images.forEach(image => {
      const imgDiv = document.createElement('div');
      imgDiv.classList.add('image-preview');

      const img = document.createElement('img');
      img.src = baseurl + 'uploads/' + image.filenameThumb;
      img.atl = 'Vehicle Image';
      imgDiv.appendChild(img);

      const deleteBtn = document.createElement('button');
      deleteBtn.innerText = 'Delete';
      deleteBtn.classList.add('delete-btn');
      deleteBtn.onclick = function() { deleteImage(imgDiv,image.image_id); };
      imgDiv.appendChild(deleteBtn);

      container.appendChild(imgDiv);
    });
  }

  function getBaseURL() {
    let currentUrl = window.location.href;
    let baseUrlParts = currentUrl.split('/'); 
    let publicIndex = baseUrlParts.indexOf('public'); 
    return baseUrlParts.slice(0, publicIndex + 1).join('/') + '/';  
  }

  function deleteImage(imgDiv, imageId) {  
    container.removeChild(imgDiv);
    deleteImageIds.push(imageId);
  }

  function htmlDecode(input) {
    var e = document.createElement('textarea');
    e.innerHTML = input;
    return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
  }

});