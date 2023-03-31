<?php
include("memberIncludesReqs.php");
require_once("Dao.php");
require_once 'table.php';
if (isset($_SESSION['mType'])) {
  $type = $_SESSION['mType'];
} else {
  err("Attempt to access edit w/out login", 'Please login to edit sessions or questions', 'signin.php');
}
if (isset($_SESSION['select'])) {
  unset($_SESSION['select']);
}
$h1 = 'Read/Send';
$type == 'tutor' ? $h1 .= '/Delete Messages' : $h1 .= ' Messages';
?>
<h1>
  <?php echo $h1 ?>
</h1>
</div>
<div id="menuBarFiveCol" class="menuBar">
  <?php
  $_POST['selected'] = 'message';
  include("menu.php");
  unset($_POST['selected']);
  $email = $_SESSION['userEmail'];
  ?>

  <div id="<?php echo $type == 'tutor' ? 'tutorBackgroundPic' : 'studentBackgroundPic' ?>" class="backgroundPicFormat">
    <?php include("formM.php");
    ?>
    <div id="formText">
      <?php
      $dao = new Dao();
      ?>

      <form method="POST" action="messageHandler.php">
        <?php
        if ($type == 'tutor') {
          ?>
          <p>
            Write the student email this message is going to:
            <input class="<?php echo classSet('sEmail') ?>" type="text" name="sEmail"
              value="<?php echo seshSet('sEmail') ?>" placeholder="ex: email@provider.net"><?php echo dot('sEmail') ?>
          </p>
          <?php
        } ?>
        <p>
          <?php
          $labelM = "Write a brief message to send to ";
          echo $type == 'tutor' ? $labelM .= 'a student:' : $labelM .= 'your tutor: ';
          ?>
          <input class="<?php echo classSet('message') ?>" type="text" name="message"
            value="<?php echo seshSet('message') ?>" placeholder="ex: great session!"><?php echo dot('message') ?>
          <input type="submit" value="Send Message!">
        </p>
        <p>
          <?php
          if ($type == 'tutor') {
          } else {
            ?>
          <div id="tableTitle">
            <?php
            echo $email . nl2br("\n");
            ?>
          </div>
          <?php
          echo table::renderTableTopNoDelete();
          $logger->LogDebug("(message) before dao get messages"); //
          $messages = $dao->getMessages($email);
          $logger->LogDebug("(MESSAGE) after dao get messages: messages length {$messages[0][0]} {$messages[0][1]} {$messages[0][2]}"); //
          echo table::renderMessageTableStudent($messages, $email);
          echo "</table>";
          }
          ?>
        </p>
      </form>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>