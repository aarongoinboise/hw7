<?php
include("titlefab.php");
include("h1s.php");
?>
<h1>Student Roster</h1>
</div>
<?php
$_POST['selected'] = 'roster';
$_POST['menutype'] = 'tutor';
?>
<div id="menuBarFourCol" class="menuBar">
    <?php
    include("menu.php");
    unset($_POST['selected']);
    unset($_POST['menutype']);
    ?>
    <div id="tutorBackgroundPic" class="backgroundPicFormat">
        <div id="smallerP">
            <details>
                <summary>Student Username and Session History</summary>
                <p>
                    Example_Student 2/18/23...
                    <span id="extra" class="historyHoverText">Discussed the categories of functions</span>
                </p>
                <hr>
                <p>
                    Example_Student 1/30/23...
                    <span id="extra" class="historyHoverText">Goofed off and complained about CS</span>
                </p>
            </details>
            <p>
                Click on the "►" to see your students.
            </p>
            <p>
                Hover over a date to see more info.
            </p>
            <p>
                To see more students click <a href=olderStudents.php>here</a>
            </p>
        </div>
        <?php include("footer.php"); ?>
    </div>
    </body>

    </html>