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
<h1>Forgot Password</h1>
</div>
<?php
$_POST['selected'] = '../signin';
$_POST['menutype'] = 'nonMemberMenuBar';
$_POST['subM'] = '->&#129335;Pass';
$POST['subphp'] = 'forgotPassword';
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
    <form method="POST" action="forgotPasswordHandler.php">
      <p>
        <label for="email">Enter the email you signed up with:</label>
        <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
          placeholder="ex: email@provider.net"><?php echo dot('email') ?>
      </p>
      <p>
      <div><input type="submit" value="Give me a hint!"></div>
      </p>
      <p>
        <a href=../signin.php>Sign In</a>
        &nbsp;&nbsp;
        <a href=resetPassword.php>Reset Password</a>
      </p>
    </form>
    <?php include("../footer.php"); ?>
  </div>
  </body>

  </html>