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
        $fullname = $row['name'];
        $email = $row['email'];

        //center all elements with first character aligned

        echo "<center>";
        echo 'Full Name';
        echo "<h6>" . $fullname . "</h6>";
        echo '<label for="recipient-name" class="col-form-label">Email</label>';
        echo "<h6>" . $email . "</h6>";
        echo '<label for="recipient-name" class="col-form-label">Matches</label>';
        echo "<h6>" . $row['matches'] . "</h6>";
        echo '<label for="recipient-name" class="col-form-label">Full Name</label>';
        echo "<h6>" . $row['wins'] . "</h6>";

        echo "</center>";
  
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
