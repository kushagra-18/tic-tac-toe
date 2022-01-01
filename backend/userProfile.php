<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<style>
  .inputImage {
    display: block;
    visibility: hidden;
    width: 0;
    height: 0;
  }
</style>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="modal fade" id="userProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Profile | <?php echo $_SESSION['username']; ?></h5>
        </button>
      </div>
      <div class="modal-body">

        <?php
        $sql = "SELECT * FROM leaderboard INNER JOIN sign_up on leaderboard.username = sign_up.username WHERE leaderboard.username = '" . $_SESSION['username'] . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        ?>

        <div class="form-group">
          <form role="form" class="form-horizontal" name="uploadImage" id="uploadImage" action="backend/upload.php" method="post" enctype="multipart/form-data">
            <center>
              <div class="imagewrap">
                <img id="uploadedImage" src=<?php echo $row['imagePath']; ?> class='img-round' alt='profile picture' width='120' height='120'>
                <input id="inputImage" name="inputImage" class="inputImage" type="file" name="somename" size="chars">
                <button type='button' id="buttonImage" onclick="" class='imgUpload btn btn-primary' data-toggle='modal' data-target='#updateProfile'><i class='fa fa-camera'></i></button>
              </div>
            </center>

            <?php

            $fullname = $row['name'];
            $email = $row['email'];

            echo "<hr>";

            echo 'Full Name';
            echo "<h6>" . $fullname . "</h6>";
            echo 'Email';
            echo "<h6>" . $email . "</h6>";
            echo 'Matches';
            echo "<h6>" . $row['matches'] . "</h6>";
            echo 'Wins';
            echo "<h6>" . $row['wins'] . "</h6>";

            ?>
            <div class="modal-footer">

              <p class="text-muted credit" style="color:#fff"><?php echo "Playing since " . $row['createdOn']; ?></p>

              <button type="submit" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
 

  $('#buttonImage').click(function() {
    $('input').click();
  });

  function formSubmit() {
    document.getElementById("uploadImage").submit();
  }
</script>