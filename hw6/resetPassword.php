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
<h1>Reset Password</h1>
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

    <form method="POST" action="resetPasswordHandler.php">
      <p>
        Your email
        <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
          placeholder="ex: email@provider.net"><?php echo dot('email') ?>
      </p>
      <p>
        Current Password
        <input class="<?php echo classSet('password') ?>" type="password" name="password"
          value="<?php echo seshSet('password') ?>" placeholder="password"><?php echo dot('password') ?>
      </p>
      <p>
        New Password
        <input class="<?php echo classSet('newPassword') ?>" type="password" name="newPassword"
          value="<?php echo seshSet('newPassword') ?>" placeholder="new password"><?php echo dot('newPassword') ?>
      </p>
      <p>
        Reenter New Password
        <input class="<?php echo classSet('reenterNewPassword') ?>" type="password" name="reenterNewPassword"
          value="<?php echo seshSet('reenterNewPassword') ?>" placeholder="reenter new password"><?php echo dot('reenterNewPassword') ?>
      </p>
      <p>
      <div><input type="submit" value="Reset My Password!"></div>
    </form>
    <div>
      <br><a href=signin.php>Sign In</a>
      &nbsp;&nbsp;
      <a href=forgotPassword.php>Forgot Password</a><br>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>