<?php
session_start();
include("titlefab.php");
include("h1s.php");
// if (isset($_SESSION['select'])) {
//   unset($_SESSION['select']);
// }
if (isset($_SESSION['userEmail'])) {
  unset($_SESSION['userEmail']);
  $_SESSION['message'] = "You logged out";
}
// if (isset($_SESSION['mType'])) {
//   unset($_SESSION['mType']);
// }
?>
<h1>Tutor Sesh: A place for tutoring.</h1>
</div>
<?php
$_POST['selected'] = 'home';
$_POST['menutype'] = 'nonMemberMenuBar';
?>
<div id="menuBarFourCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  unset($_POST['menutype']);
  ?>
  <div id="homeBackgroundPic" class="backgroundPicFormat">
    <?php include("formM.php");
    ?>
    <h2>Waiting for your session to start? Try this:</h2>
    <div id="p">
      <p>
        Given a string, write a program that finds the length of the longest substring without repeating characters.
      </p>
      <p>
        Example: Given "abcabcb", the answer is "abc" since the length is 3.
      </p>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>