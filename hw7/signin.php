<?php
session_start();
sleep(0.3);
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
<h1>Sign In</h1>
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
    <form method="POST" action="signinHandler.php">
      <p>
        <label for="email">Email:</label>
        <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
          placeholder="ex: email@provider.net"><?php echo dot('email') ?>
          &nbsp;&nbsp;
        <label for="password">Password:</label>
        <input class="<?php echo classSet('password') ?>" type="password" name="password"
          value="<?php echo seshSet('password') ?>" placeholder="password"><?php echo dot('password') ?>
      </p>
      <p>
      <div><input type="submit" value="Login!"></div>
      </p>
      <p>
        <a href=signin/forgotPassword.php>Forgot Password?</a>
        &nbsp;&nbsp;
        <a href=signin/resetPassword.php>Reset Password</a>
      </p>
    </form>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>