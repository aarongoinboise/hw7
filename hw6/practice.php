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

?>
<h1>Practice!</h1>
</div>
<?php
$_POST['selected'] = 'practice';

if (isset($_SESSION['select'])) {
  unset($_SESSION['select']);
}
?>
<div id="menuBarFiveCol" class="menuBar">
  <?php
  $_POST['selected'] = 'practice';
  include("menu.php");
  unset($_POST['selected']);
  $email = $_SESSION['userEmail'];
  ?>
  <div id="<?php echo $type == 'tutor' ? 'tutorBackgroundPic' : 'studentBackgroundPic' ?>" class="backgroundPicFormat">
    <?php include("formM.php");
    echo "<div id=\"varyP\">";
    $dao = new Dao();
    if ($type != 'tutor') {
      $practice = $dao->getPractice($email);
      $rightAns = $practice[0][3];
      $rand1 = rand(1, 3);
      $rand2 = rand(1, 3);
      while ($rand2 === $rand1) {
        $rand2 = rand(1, 3);
      }
      $remNum = 6 - $rand1 - $rand2;
      if ($rightAns == $practice[0][$rand1]) {
        $rightNum = $rand1;
      } elseif ($rightAns == $practice[0][$rand2]) {
        $rightNum = $rand2;
      } else {
        $rightNum = $remNum;
      }
      $_POST['rightNum'] = $rightNum;

      echo table::renderTableTopP($email);
      echo table::renderPracticeTableStudent($email, $practice, $practice[0][$rand1], $practice[0][$rand2], $practice[0][$remNum]);
    } else {
      $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
      if (count($emails) == 0) {
        echo "You have no students, which means no practice questions!";
        $noStudentsT = true;
      } else {
        foreach ($emails as $e) {
          $practice = $dao->getPractice($e[0]);
          echo table::renderTableTopP($e[0]);
          echo table::renderPracticeTableStudentT($e[0], $practice, $practice[0][1], $practice[0][2], $practice[0][3]);
        }
        ?>
        <?php
      }
    }
    //find random vals for the checkbox ids
    if (!$noStudentsT) {
      if ($type != 'tutor') { ?>
        <form method="POST" action="practiceHandler.php">
          <tr>
            <td></td>
            <td><input type="radio" name="opt" value="<?php echo $practice[0][$rand1] ?>"<?php echo findRadioBtnSelect($practice[0][$rand1]) ?>></td>
            <td><input type="radio" name="opt" value="<?php echo $practice[0][$rand2] ?>"<?php echo findRadioBtnSelect($practice[0][$rand2]) ?>></td>
            <td><input type="radio" name="opt" value="<?php echo $practice[0][$remNum] ?>"<?php echo findRadioBtnSelect($practice[0][$remNum]) ?>></td>
          </tr>
          </table>
          <p>
            <input type="submit" value="Submit Your Answer!">
          </p>
        </form>
      <?php } else { ?>
        </table>
        <p id="smallerP">
          Edit your student's practice questions <a href=edit.php>here</a>
        </p>
      <?php }
    } ?>
  </div>
  <?php include("footer.php"); ?>
</div>
</body>

</html>