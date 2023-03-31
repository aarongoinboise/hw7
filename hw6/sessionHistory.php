<?php
include("memberIncludesReqs.php");
require_once("Dao.php");
require_once 'table.php';
if (isset($_SESSION['mType'])) {
  $type = $_SESSION['mType'];
} else {
  err("Attempt to access edit w/out login", 'Please login to see sessions', 'signin.php');
}
if (isset($_SESSION['select'])) {
  unset($_SESSION['select']);
}
?>
<h1>Session History</h1>
</div>
<?php
$_POST['selected'] = 'sessionHistory';
?>
<div id="menuBarFiveCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  $email = $_SESSION['userEmail'];
  ?>
  <div id="<?php echo $type == 'tutor' ? 'tutorBackgroundPic' : 'studentBackgroundPic' ?>" class="backgroundPicFormat">
    <?php include("formM.php");
    ?>
    <div id="smallerP">
      <?php
      $dao = new Dao();
      ?>
          <?php
          if ($type == 'tutor') {
            $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
            if (count($emails) == 0) {
              echo "You have no students, which means no session histories!";
            }
            foreach ($emails as $e) {
              echo table::renderTableTop();
              ?>
              <div id="tableTitle">
                <?php
                echo $e[0] . nl2br("\n");
                ?>
              </div>
              <?php
              $sessionHistory = $dao->getSessionHistory($e[0]);
              echo table::renderSessionTableStudent($sessionHistory);
              echo "</table>";
            }
            $x++;

          } else {
            ?>
            <div id="tableTitle">
              <?php
              echo $email . nl2br("\n");
              ?>
            </div>
            <?php
            echo table::renderTableTop();
            $sessionHistory = $dao->getSessionHistory($email);
            echo table::renderSessionTableStudent($sessionHistory);
            echo "</table>";
          } // end of else
          ?>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>