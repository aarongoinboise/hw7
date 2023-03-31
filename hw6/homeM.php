<?php
include("memberIncludesReqs.php");
require_once 'Dao.php';
if (isset($_SESSION['mType'])) {
    $type = $_SESSION['mType'];
} else {
    err("Attempt to access home w/out login", 'Please login to access homepage', 'signin.php');
}
if (isset($_SESSION['select'])) {
    unset($_SESSION['select']);
}
// if (isset($_SESSION['inputs'])) {
//     unset($_SESSION['inputs']);
// }
?>
<h1>
    <?php echo $type == 'tutor' ? 'Tutor' : 'Student' ?> Home
</h1>
</div>
<div id="menuBarFiveCol" class="menuBar">
    <?php
    $_POST['selected'] = 'homeM';
    include("menu.php");
    unset($_POST['selected']);
    $email = $_SESSION['userEmail'];
    ?>
    <div id="<?php echo $type == 'tutor' ? 'tutorBackgroundPic' : 'studentBackgroundPic' ?>"
        class="backgroundPicFormat">
        <?php include("formM.php");
        $dao = new Dao();
        ?>
        <div id="h2">Welcome
            <?php echo $email ?>!
            <?php if ($type == 'tutor') {
                echo "AKA Tutor # " . $dao->getTutorNumber($email);
            } ?>
        </div>
        <div id="sTHomeText">
            <p>
                You had your last session on . Click <a href=sessionHistory.php>here</a> to see more information.
            </p>
            <p>
                You have 1 new message from your tutor OR '' will be displayed.
            </p>
            <p>
                Next Tutor Session: (2/24/23 from 2PM-4PM)
            </p>
            <p>
            <form id="formType" action="homeMHandler.php">
                To logout and return to the login page, click <input type="submit" value="here">
            </form>
            Or, you can simply visit a non-member page to logout.
            </p>
        </div>
        <?php include("footer.php"); ?>
    </div>
    </body>

    </html>