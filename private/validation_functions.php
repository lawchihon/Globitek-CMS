<?php

  // is_blank('abcd')
  function is_blank($value='') {
    // TODO
    return strlen($value) == 0;
  }

  // has_length('abcd', ['min' => 3, 'max' => 5])
  function has_length($value, $options=array()) {
    // TODO
    $min = isset($options['min']) ? $options['min'] : 1;
    $max = isset($options['max']) ? $options['max'] : 255;

    return strlen($value) >= $min && strlen($value) <= $max;
  }

  // has_valid_email_format('test@test.com')
  function has_valid_email_format($value) {
    // TODO
    return filter_var($value, FILTER_VALIDATE_EMAIL);
  }

  // has_valid_name_character('John')
  function has_valid_name_character($value) {
    return preg_match('/\A[A-Za-z\s\-,\.\']+\Z/', $value);
  }
  
  // has_valid_username_character('lawchihon')
  function has_valid_username_character($value) {
    return preg_match('/\A[A-Za-z0-9\_]+\Z/', $value);
  }

  // has_valid_email_character('chlaw@ucsd.edu')
  function has_valid_email_character($value) {
    return preg_match('/\A[A-Za-z0-9\_\@\.]+\Z/', $value);
  }
  
  function has_unique_username($db, $value) {
    $sql = "SELECT * FROM users WHERE username='$value';";
    $result = db_query($db, $sql);
    if($result) {
      return $result->num_rows == 0;
    } else {
      // The SQL INSERT statement failed.
      // Just show the error, not the form
      echo db_error($db);
      db_close($db);
      exit;
    }
  }
?>
