<?php
$pages;
if ($_POST['menutype'] == "nonMemberMenuBar") {
  $pages = array("Home" => "home", "Sign In" => "signin", "Sign Up" => "signup", "About" => "about");
} else {
  $pages = array("Home" => "homeM", "Sessions" => "sessionHistory", "Add/Edit Session/Practice" => "edit", "Messages" => "message", "Practice" => "practice");
}// roster, edit, student/tutormessage
foreach ($pages as $key => $val) {
  $selected = false;
  if ($val == $_POST['selected']) {
    $selected = true;
    ?>
    <span id="menuBarItemSelected">
    <?php
  }
  ?>
    <div class="menuBarItem"><a href=<?php echo $val . ".php" ?>><?php echo $key ?></a></div>
    <?php
    if ($selected == true) {
      ?>
    </span>
  <?php
    }
}
?>