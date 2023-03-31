<?php
$color;
if (isset($_SESSION['message'])) {
  if ($_SESSION['message'] == "You logged out") {
    $color = 'neutralMessage';
  } else if (strpos($_SESSION['message'], "Success") === false) {
    $color = 'errMessage';
  } else {
    $color = 'posMessage';
  }
  echo "<div id='{$color}' class='messageParam'>" . $_SESSION['message'] . "</div>";
  unset($_SESSION['message']);
} else {
  unset($_SESSION['inputs']);
  unset($_SESSION['red']);
}