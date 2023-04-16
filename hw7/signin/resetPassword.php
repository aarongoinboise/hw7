<?php
session_start();
sleep(0.3);
include("titlefabS.php");
include("h1sS.php");
require_once("../saveFormTxt.php");
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
$_POST['selected'] = '../signin';
$_POST['menutype'] = 'nonMemberMenuBar';
$_POST['subM'] = '->&#9194;Pass';
$POST['subphp'] = 'resetPassword';
?>
<div id="menuBarFourCol" class="menuBar">
  <?php
  include("menuS.php");
  unset($_POST['selected']);
  unset($_POST['menutype']);
  unset($_POST['subM']);
  unset($POST['subphp']);
  ?>

  <div id="signInBackgroundPic" class="backgroundPicFormat">
    <?php include("../formM.php");
    ?>

    <form method="POST" name="resetPassword" action="resetPasswordHandler.php">
      <p>
        <label for="email">Your email</label>
        <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
          placeholder="ex: email@provider.net"><?php echo dot('email') ?>
      </p>
      <p>
        <label for="password">Current Password</label>
        <input class="<?php echo classSet('password') ?>" type="password" name="password"
          value="<?php echo seshSet('password') ?>" placeholder="password"><?php echo dot('password') ?>
      </p>
      <p>
        <label for="newPassword">New Password</label>
        <input class="<?php echo classSet('newPassword') ?>" type="password" name="newPassword" id="newPassword"
          value="<?php echo seshSet('newPassword') ?>" placeholder="new password"><?php echo dot('newPassword') ?>
      </p>
      <p>
        <label for="reenterNewPassword">Reenter New Password</label>
        <input class="<?php echo classSet('reenterNewPassword') ?>" type="password" name="reenterNewPassword"
          value="<?php echo seshSet('reenterNewPassword') ?>" placeholder="reenter new password"><?php echo dot('reenterNewPassword') ?>
      </p>
      <p>
        <label for="hint">Enter a new hint (to remind yourself of the password)</label>
        <input class="<?php echo classSet('hint') ?>" type="text" name="hint"
          value="<?php echo seshSet('hint') ?>" placeholder="ex: favorite number"><?php echo dot('hint') ?>
      </p>
      <p>
      <div><input type="submit" value="Reset My Password!"></div>
    </form>
    <div>
      <br><a href=../signin.php>Sign In</a>
      &nbsp;&nbsp;
      <a href=forgotPassword.php>Forgot Password</a><br>
    </div>
    <?php include("../footer.php"); ?>
  </div>
  </body>

  </html>