<?php
include("titlefab.php");
include("h1s.php");
?>
<h1>Record Session</h1>
</div>
<?php
$_POST['selected'] = 'recordSession';
$_POST['menutype'] = 'student';
?>
<div id="menuBarFiveCol" class="menuBar">
  <?php
  include("menu.php");
  unset($_POST['selected']);
  unset($_POST['menutype']);
  ?>
  <div id="studentBackgroundPic" class="backgroundPicFormat">
    <div id="smallerP">
      <p>
        Please enter the session date (month/day/year):
        <input type="text" id="Date" name="Date" placeholder="Ex: 3/14/15">
      </p>
      <p>
        Write a brief description on what you did in your session:
        <input type="text" id="Description" name="Description" placeholder="Description">
      </p>
      <p>
        <button type="button" onclick="alert('Your session has been saved!')">Submit</button>
      </p>
    </div>
    <?php include("footer.php"); ?>
  </div>
  </body>

  </html>