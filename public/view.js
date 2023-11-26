document.addEventListener("DOMContentLoaded", function(){
  
  const commerntForm = document.getElementById('commerntForm');
  
  commerntForm.addEventListener('submit', function(event) {
    event.preventDefault();
    submitComment();
  });

  //Init data
  // const params = new URLSearchParams(window.location.search);
  // const vehicle_id = params.get('id');
  const pathParts = window.location.pathname.split('/');
  const vehicle_id = pathParts[pathParts.length - 3];  
  const slug = pathParts[pathParts.length - 2];
  if(!vehicle_id || !slug){
    alert('Init data failed.');
    window.location.href = 'signin_processor.php';
  }
  
  initData();

  function initData(){
    let formData = new FormData();
    formData.append('vehicle_id',vehicle_id);
    formData.append('action', 'viewVehicle');
    formData.append('command', 'View');
    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          document.getElementById('make').innerHTML = data['data']['baseinfo']['make'];
          document.getElementById('model').innerHTML = data['data']['baseinfo']['model'];
          document.getElementById('category_name').innerHTML = data['data']['baseinfo']['category_name'];
          document.getElementById('year').innerHTML = data['data']['baseinfo']['year'];
          document.getElementById('price').innerHTML = data['data']['baseinfo']['price'];
          document.getElementById('mileage').innerHTML = data['data']['baseinfo']['mileage'];
          document.getElementById('exterior_color').innerHTML = data['data']['baseinfo']['exterior_color'];
          document.getElementById('description').innerHTML = data['data']['baseinfo']['description'];
          document.getElementById('create_time').innerHTML = data['data']['baseinfo']['create_time'];

          showComments(data['data']['commentinfo']);
          showImages(data['data']['imageinfo']);
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
    let commentsContainer = document.getElementById('comments');
    commentsContainer.innerHTML = '';

    comments.forEach(function(comment) {
      let commentDiv = document.createElement('div');
      commentDiv.classList.add('comment');

      let contentP = document.createElement('p');
      let infoSpan = document.createElement('span');
      infoSpan.classList.add('comment-info');
      infoSpan.style.color = 'gray';
      infoSpan.style.fontStyle = 'italic';
      infoSpan.style.fontSize = '0.8em';
      infoSpan.textContent = comment.username + ' posted at:' + comment.create_date;
      contentP.appendChild(infoSpan);

      let infoDiv = document.createElement('div');
      infoDiv.innerHTML = comment.content;
      contentP.appendChild(infoDiv);
      
      commentDiv.appendChild(contentP);

      commentsContainer.appendChild(commentDiv);
    });
  }

  function submitComment(){
    let formData = new FormData(commerntForm);
    formData.append('vehicle_id',vehicle_id);
    formData.append('action', 'viewVehicle');
    formData.append('command', 'Submit');

    fetch('request.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          alert('Creating New Data Succeeded!');
          window.location.reload();
        }
        else{
          alert(data['message']);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }

  function showImages(images){
    if(!images || images.length <=0)
      return;
    
    let carouselControls = document.getElementById('carouselControls');
    carouselControls.style.display = 'block';
    let carouselImages = document.getElementById('carouselImages');
    let baseurl = getBaseURL();
    let galleryLinks = [];

    images.forEach(function(image, index) {
        let carouselItem = document.createElement('div');
        carouselItem.className = 'carousel-item' + (index === 0 ? ' active' : ''); // Active the first image

        let link = document.createElement('a');
        link.href = baseurl + 'uploads/' + image.filename; // Link to the original image
        galleryLinks.push(link);

        var img = document.createElement('img');
        img.className = 'd-block';
        img.src = baseurl + 'uploads/' + image.filenameMedium;
        img.alt = 'Vehicle Image';

        link.appendChild(img);
        carouselItem.appendChild(link);
        carouselImages.appendChild(carouselItem);
    });
    new LuminousGallery(galleryLinks);

  }

  function getBaseURL() {
    let currentUrl = window.location.href;
    let baseUrlParts = currentUrl.split('/'); 
    let publicIndex = baseUrlParts.indexOf('public'); 
    return baseUrlParts.slice(0, publicIndex + 1).join('/') + '/';  
  }

});