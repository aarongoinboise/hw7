<?php
session_start();
include("titlefab.php");
include("h1s.php");
require_once("saveFormTxt.php");
if (isset($_SESSION['select'])) {
  unset($_SESSION['select']);
}
if (isset($_SESSION['userEmail'])) {
  unset($_SESSION['userEmail']);
  if (isset($_SESSION['inputs'])) {
    unset($_SESSION['inputs']);
  }
  $_SESSION['message'] = "You logged out";
}
if (isset($_SESSION['mType'])) {
  unset($_SESSION['mType']);
}
?>
<h1>Forgot Password</h1>
</div>
<?php
$_POST['selected'] = 'signin';
$_POST['menutype'] = 'nonMemberMenuBar';
?>
<div id="menuBarFourCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  unset($_POST['menutype']);
  ?>

  <div id="signInBackgroundPic" class="backgroundPicFormat">
    <?php include("formM.php");
    ?>
    <form method="POST" action="forgotPasswordHandler.php">
      <p>
        Enter the email you signed up with:
        <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
          placeholder="ex: email@provider.net"><?php echo dot('email') ?>
      </p>
      <p>
      <div><input type="submit" value="Give me a hint!"></div>
      </p>
      <p>
        <a href=signin.php>Sign In</a>
        &nbsp;&nbsp;
        <a href=resetPassword.php>Reset Password</a>
      </p>
    </form>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>