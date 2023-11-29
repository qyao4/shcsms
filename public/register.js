document.addEventListener('DOMContentLoaded', (event) => {
  const registrationForm = document.getElementById('registrationForm');
  
  registrationForm.addEventListener('submit', function(e) {
      e.preventDefault(); // Prevent the default form submit action

      // Check if the passwords match
      const password = document.getElementById('new_password').value;
      const confirmPassword = document.getElementById('new_confirmPassword').value;
      if (password !== confirmPassword) {
          alert('Passwords do not match. Please try again.');
          return; // If passwords don't match, stop the function execution
      }
      
      // Create a FormData instance
      let formData = new FormData(this);
      formData.append('action', 'register');
      for (let [key, value] of formData.entries()) {
        console.log(key, value);
      }

      // Use fetch to send a POST request
      fetch('request.php', {
          method: 'POST',
          body: formData
      })
      .then(response => response.json())
      .then(data => {
          console.log('data:',data);
          if(data['result'] == 'succ'){
            alert('register successfully!');
            window.location.href = 'home/';
          }
          else{
            alert(data['message']);
          }
      })
      .catch((error) => {
          console.error('Error:', error);
      });

      // .then(response => response.json()) // Assuming the server responds with JSON
      // .then(data => {
      //     // Process the response data
      //     console.log(data);
      //     if (data.success) {
      //       alert('register successfully!');
      //         // Actions to take after successful registration, like redirecting to a login page
      //         //window.location.href = 'login.php';
      //     } else {
      //         // Display an error message
      //         alert(data.message);
      //     }
      // })
      // .catch(error => {
      //     // Error handling
      //     console.error('Error:', error);
      // });
  });
});
