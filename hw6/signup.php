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
<h1>Sign Up</h1>
</div>
<?php
$_POST['selected'] = 'signup';
$_POST['menutype'] = 'nonMemberMenuBar';
?>
<div id="menuBarFourCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  unset($_POST['menutype']);
  ?>

  <div id="signUpBackgroundPic" class="backgroundPicFormat">
    <?php include("formM.php");
    ?>
    <div id="formText">

      <form method="POST" action="signupHandler.php">
        <p>
          Please enter a valid email address (students: only share this with your tutor):
          <input class="<?php echo classSet('email') ?>" type="text" name="email" value="<?php echo seshSet('email') ?>"
            placeholder="ex: email@provider.net"><?php echo dot('email') ?>
        </p>
        <p>
          Please enter a secure password (don't share this with anyone):
          <input class="<?php echo classSet('password') ?>" type="password" name="password"
            value="<?php echo seshSet('password') ?>" placeholder="password"><?php echo dot('password') ?>
        </p>
        <p>
          Please reenter the same password you entered above:
          <input class="<?php echo classSet('reenterPassword') ?>" type="password" name="reenterPassword"
            value="<?php echo seshSet('reenterPassword') ?>" placeholder="Reenter Password"><?php echo dot('reenterPassword') ?>
        </p>
        <p>
          Enter a question or hint whose answer is your password (don't share this with anyone):
          <input class="<?php echo classSet('hint') ?>" type="text" name="hint" value="<?php echo seshSet('hint') ?>"
            placeholder="ex: nickname"><?php echo dot('hint') ?>
        </p>
        <div>
          If you are a tutor, simply write "tutor".
          <br>Otherwise, please provide your tutor's ID number:
          <input class="<?php echo classSet('tutor') ?>" type="text" name="tutor" value="<?php echo seshSet('tutor') ?>"
            placeholder="tutor or tutor's ID"><?php echo dot('tutor') ?>
        </div>
        <p>
          Please double-check your information before signing up.&#11014;&#10004;
        </p>
        <div><input type="submit" value="Sign Me Up!"></div>
        <p>
        </p>
      </form>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>