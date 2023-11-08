<?php
    /*******w******** 
    
    Name: Qiang Yao
    Date: 2023-11-07
    Description: sign in component
    ****************/
    
    //$shouldShowModal = !isset($_SESSION['user_logged_in']);
    // $need_authenticated = true;
?>
<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Sign In</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form id="loginForm" action="signin_processor.php" method="POST">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
            <input type="text" style="display: none" name="type" 
                  value="<?= isset($need_authenticated) && $need_authenticated ? 'authenticate' : 'login'; ?>">
            <button type="submit" class="btn btn-primary">Sign In</button>
          </form>
        </div>
      </div>
    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script>
  var showModal = <?php echo isset($need_authenticated) && $need_authenticated ? 'true' : 'false'; ?>;
  $(document).ready(function(){
    // Show the modal on page load
    if(showModal)
      $('#loginModal').modal('show');
  });
  
  if(showModal){
    $('#loginModal').on('hidden.bs.modal', function () {
      // Replace 'your_target_page.php' with the page you want to redirect to
      window.location.href = 'signin_processor.php';
    });
  }
  
</script>