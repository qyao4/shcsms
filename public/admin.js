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
  let sortDirection = '';
  let sortField = '';

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
    formData.append('sortDirection',sortDirection);
    formData.append('sortField',sortField);
    
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
          for (var key in vehicle) {
            if (vehicle.hasOwnProperty(key) && key!='vehicle_id') {
              let cell = row.insertCell();
              let content = vehicle[key];
              cell.textContent = content;
            }
          }
          let editCell = row.insertCell();
          let editLink = document.createElement('a');
          editLink.innerHTML = 'edit';
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
      window.location.href = `edit.php?id=${vehicleData['vehicle_id']}`;
  }

  document.querySelectorAll('th').forEach(function(header) {
    header.addEventListener('click', function() {
        const sortIcon = header.querySelector('i.fas');
        const isAscending = sortIcon.classList.contains('fa-sort-up');
        
        document.querySelectorAll('th i.fas').forEach(function(icon) {
            icon.classList.remove('fa-sort-up', 'fa-sort-down');
            icon.classList.add('fa-sort');
        });

        if (isAscending) {
            sortIcon.classList.remove('fa-sort', 'fa-sort-up');
            sortIcon.classList.add('fa-sort-down');
        } else {
            sortIcon.classList.remove('fa-sort', 'fa-sort-down');
            sortIcon.classList.add('fa-sort-up');
        }

        console.log('sortDirection', isAscending);
        console.log('sortField',header.textContent.trim());

        sortDirection = isAscending ? 'ASC':'DESC';
        sortField = header.id;
        performSearch();
    });
});

});