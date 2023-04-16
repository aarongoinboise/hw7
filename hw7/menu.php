<?php
$pages;
if ($_POST['menutype'] == "nonMemberMenuBar") {
  $pages = array("Home" => "home", "Sign In" => "signin", "Sign Up" => "signup", "About" => "about");
} else {
  $pages = array("Home" => "homeM", "Sessions" => "sessionHistory", "Practice" => "practice", "Messages" => "message", "Add/Edit Session/Practice" => "edit");
} // roster, edit, student/tutormessage
foreach ($pages as $key => $val) {
  $selected = false;
  $phplink = $val;
  $subM = '';
  if ($val == $_POST['selected']) {
    $selected = true;
    $subM = '';
    if ($key == "Sign In") {
      if (isset($_POST['subM'])) {
        $subM = $_POST['subM'];
        $phplink = $POST['subphp'];
      }
    }
    ?>
    <span id="menuBarItemSelected">
      <?php
  }
  if ($key == "Sign In" && isset($_POST['subM'])) {
    ?>
      <div class="menuBarItem"><a href="signin.php">Sign In</a><a href=<?php echo $phplink . ".php" ?>><?php echo $subM ?></a></div>
      <?php
  } else {
    ?>
      <div class="menuBarItem"><a href=<?php echo $phplink . ".php" ?>><?php echo $key . $subM ?></a></div>
    <?php }
  if ($selected == true) {
    ?>
    </span>
    <?php
  }
}
?>