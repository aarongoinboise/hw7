<?php
include("titlefab.php");
include("h1s.php");
?>
<h1>Practice!</h1>
</div>
<?php
$_POST['selected'] = 'practiceS';

if (isset($_SESSION['select'])) {
  unset($_SESSION['select']);
}
?>
<div id="menuBarFiveCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  ?>
  <div id="studentBackgroundPic" class="backgroundPicFormat">
    <div id="mediumP">
      <p>
        Hi Example_Student!
      </p>
      <p>
        Your tutor wants you to practice the following questions about print statements..
      </p>
      <p>
        1. Which of the following print statements will create a new line?
      </p>
    </div>
    <p id="smallerP">
      <input type="checkbox" id="wrong1" name="wrong1"> System.out.print("\ n");
      &nbsp;<input type="checkbox" id="wrong1" name="wrong1"> System.out.println();
      &nbsp;<input type="checkbox" id="wrong1" name="wrong1"> System.out.printf("%s", "\ n");
    <p>
      <button type="button" onclick="alert('Correct or Incorrect, depending on selection')">Submit Your Answer</button>
    </p>
    </p>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>