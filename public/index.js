// Add document load event listener
document.addEventListener("DOMContentLoaded", function(){
  const prevButton = document.getElementById("prevPage");
  const nextButton = document.getElementById("nextPage");
  const currentPageSpan = document.getElementById("currentPage");
  const totalPagesSpan = document.getElementById("totalPages");
  let currentPage = 1;
  let totalPages = 1;
  const recordsPerPage = 10;
  let currentData = [];
  const searchForm = document.getElementById('searchForm');

  searchForm.addEventListener('submit', function(event) {
    event.preventDefault();
    performSearch();
  });

  prevButton.addEventListener("click", function() {
    if (currentPage > 1) {
        currentPage--;
        displayResults(currentData.slice((currentPage - 1) * recordsPerPage, currentPage * recordsPerPage));
    }
  });
  
  nextButton.addEventListener("click", function() {
    if (currentPage < totalPages) {
        currentPage++;
        displayResults(currentData.slice((currentPage - 1) * recordsPerPage, currentPage * recordsPerPage));
    }
  });

  function performSearch() {
    let formData = new FormData(searchForm);
    formData.append('action', 'search');

    
  
    // Perform the AJAX request
    fetch('request.php?',{
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
        console.log('data:',data);
        if(data['result'] == 'succ'){
          currentData = data.data;
          totalPages = Math.ceil(data.data.length / recordsPerPage);
          displayResults(currentData.slice(0, recordsPerPage));
        }
        else{
          console.error('Error Message:',data['message']);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
  }
  
  function displayResults(data) {
    const resultsBody = document.getElementById('searchResults').getElementsByTagName('tbody')[0];
      resultsBody.innerHTML = ''; // Clear current results
  
      // Loop through each vehicle in the data array
      data.forEach(vehicle => {
          const row = resultsBody.insertRow();
          // row.innerHTML = `
          //     <td>${vehicle.make}</td>
          //     <td>${vehicle.model}</td>
          //     <td>${vehicle.category_name}</td>
          //     <td>${vehicle.year}</td>
          //     <td>${vehicle.price}</td>
          //     <td>${vehicle.mileage}</td>
          //     <td>${vehicle.exterior_color}</td>
          //     <td>
          //       <a href="#" class="btn btn-info" role="button" 
          //       onclick="handleRowLinkClick(${JSON.stringify(vehicle).split('"').join("&quot;")}); 
          //       return false;">Details</a>
          //     </td>
          // `;
          for (var key in vehicle) {
            if (vehicle.hasOwnProperty(key) && key != 'vehicle_id' && key != 'slug') {
              let cell = row.insertCell();
              let content = vehicle[key];
              cell.textContent = content;
            }
          }
          let editCell = row.insertCell();
          let editLink = document.createElement('a');
          editLink.innerHTML = 'view';
          editLink.className = 'table-edit';
          editLink.addEventListener("click",function(){
            handleRowLinkClick(vehicle);
          })
          editCell.appendChild(editLink);
      });
      // Update pagination if necessary
      currentPageSpan.textContent = currentPage;
      totalPagesSpan.textContent = totalPages;
      prevButton.disabled = currentPage === 1;
      nextButton.disabled = currentPage === totalPages;
  }

  function handleRowLinkClick(vehicleData) {
      console.log(vehicleData);
      // window.location.href = `view.php?id=${vehicleData['vehicle_id']}`;
      let slugText = vehicleData['slug'];
      window.location.href = `vehicles/${vehicleData['vehicle_id']}/${slugText}/`;
  }

});