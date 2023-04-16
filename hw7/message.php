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
    $dao = new Dao();
    ?>

    <form method="POST" action="messageHandler.php">
      <div id="varyP">
        <?php
        $noStudentsT = false;
        if ($type == 'tutor') {
          $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
          if (count($emails) == 0) {
            echo "You have no students, which means no messages!";
            $noStudentsT = true;
          }
          if (!$noStudentsT) {
            ?>
            <p>
              <label for="sEmail">Write the student email this message is going to:</label>
              <select name="sEmail" id="sEmail">
                <option value="" hidden>Student Email</option>
                <?php
                $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
                foreach ($emails as $e) { ?>
                  <option value=<?php echo $e[0] . ' ' . findSelectedOptSE($e[0]) ?>><?php echo $e[0] ?></option>
                <?php } ?>
              </select>
              <?php echo dot('sEmail') 
              ?>
            </p>
            <?php
          }
          if (isset($_SESSION['emailS'])) {
            unset($_SESSION['emailS']);
        }
        }
        if (!$noStudentsT) {
          echo "<p>";
          $labelM = "<label for=\"message\">Write a brief message to send to ";
          echo $type == 'tutor' ? $labelM .= 'a student:' : $labelM .= 'your tutor:';
          echo "</label>";
          ?>
          <input class="<?php echo classSet('message') ?>" type="text" name="message"
            value="<?php echo seshSet('message') ?>" placeholder="ex: great session!"><?php echo dot('message') ?>
          <input type="submit" value="Send Message!">
          </p>
          <p>
            <?php
        }
        if ($type == 'tutor' && !$noStudentsT) {
          foreach ($emails as $e) {
            echo table::renderTableTopM($e[0]);
            ?>
              <?php
              ?>
              <?php
              $messages = $dao->getMessages($e[0]);
              echo table::renderMessageTableStudent($messages, $e[0], $email, true);
              echo "</table>";
          }
          $x++;

        } elseif (!$noStudentsT) {
          ?>
            <!-- <div id="tableTitle">
            <?php
            // echo $email . nl2br("\n");
            ?>
          </div> -->
            <?php
            echo table::renderTableTopMNoDelete($email);
            $messages = $dao->getMessages($email);
            echo table::renderMessageTableStudent($messages, $email, $dao->getTutorEmailFromStudent($email), false);
            echo "</table>";
        }
        if (!$noStudentsT) {
          echo "</p>";
        }
        ?>
      </div>
    </form>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>