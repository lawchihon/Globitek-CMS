<?php
  require_once('../private/initialize.php');

  // Set default values for all variables the page needs.
  $firstName = isset($_POST['firstName']) ? $_POST['firstName'] : '';
  $lastName = isset($_POST['lastName']) ? $_POST['lastName'] : '';
  $email = isset($_POST['email']) ? $_POST['email'] : '';
  $username = isset($_POST['username']) ? $_POST['username'] : '';

  // if this is a POST request, process the form
  // Hint: private/functions.php can help
  if(is_post_request()) {

    // Confirm that POST values are present before accessing them.

    // Perform Validations
    // Hint: Write these in private/validation_functions.php
    $errors = array();

    if (is_blank($firstName)) {
      //$errors[] = "First name cannot be blank.";
      array_push($errors, "First name cannot be blank.");
    }
    else if (!has_length($firstName, array("min" => 2))) {
      array_push($errors, "First name must be in between 2 and 255 characters.");
    }
    else if (!has_valid_name_character($firstName)) {
      array_push($errors, "First name can only contain letters, spaces, symbols: - , . '");
    }

    if (is_blank($lastName)) {
      array_push($errors, "Last name cannot be blank.");
    }
    else if (!has_length($firstName, array("min" => 2))) {
      array_push($errors, "Last name must be in between 2 and 255 characters.");
    }
    else if (!has_valid_name_character($lastName)) {
      array_push($errors, "Last name can only contain letters, spaces, symbols: - , . '");
    }
    
    if (is_blank($email)) {
      array_push($errors, "Email cannot be blank.");
    }
    else if (!has_length($email, array())) {
      array_push($errors, "Email must be in between 1 and 255 characters.");
    }
    else if (!has_valid_email_format($email)) {
      array_push($errors, "Email must be a valid format.");
    }
    else if (!has_valid_email_character($email)) {
      array_push($errors, "Email can only contain letters, numbers, symbols: _ @ .");
    }
      
    if (is_blank($username)) {
      array_push($errors, "Username cannot be blank.");
    }
    else if (!has_length($username, array("min" => 8))) {
      array_push($errors, "Username must be in between 8 and 255 characters.");
    }
    else if (!has_valid_username_character($username)) {
      array_push($errors, "Username can only contain letters, numbers, symbols: _");
    }
    else if (!has_unique_username($db, $username)) {
      array_push($errors, "Username has been taken.");
    }

    // if there were no errors, submit data to database
    if (empty($errors)) {

      // Write SQL INSERT statement
      $createdAt = date("Y-m-d H:i:s");
      //
      $sql = "INSERT INTO users (first_name, last_name, email, username, created_at) VALUES ('$firstName', '$lastName', '$email', '$username', '$createdAt');";

      // For INSERT statments, $result is just true/false
      $result = db_query($db, $sql);
      if($result) {
        db_close($db);

        // TODO redirect user to success page
        $url = "registration_success.php";
        redirect_to($url);
      } else {
        // The SQL INSERT statement failed.
        // Just show the error, not the form
        echo db_error($db);
        db_close($db);
        exit;
      }
    }
  }
?>

<?php $page_title = 'Register'; ?>
<?php include(SHARED_PATH . '/header.php'); ?>

<div id="main-content">
  <h1>Register</h1>
  <p>Register to become a Globitek Partner.</p>

  <?php
    // TODO: display any form errors here
    // Hint: private/functions.php can help
    echo display_errors($errors);
  ?>

  <!-- TODO: HTML form goes here -->
  <form action="register.php" method="post">
    <p>First Name: </p>
    <p><input type="text" name="firstName" value="<?php echo h($firstName); ?>" /></p>
    <p>Last Name: </p>
    <p><input type="text" name="lastName" value="<?php echo h($lastName); ?>" /></p>
    <p>Email: </p>
    <p><input type="text" name="email" value="<?php echo h($email); ?>" /></p>
    <p>Username: </p>
    <p><input type="text" name="username" value="<?php echo h($username); ?>" /></p>
    <p><input type="submit" name="submit" value="Submit" /></p>
  </form>
</div>

<?php include(SHARED_PATH . '/footer.php'); ?>
