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
                You had your last session on
                <?php if ($type != 'tutor') {
                echo $dao->getLastSession($email);
                } else {
                    $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
                    $newestSesh = date('d-m-Y', 0);
                    foreach ($emails as $e) {
                        $logger->LogDebug("curr email: {$e[0]}");
                        $currSesh = $dao->getLastSession($e[0]);
                        if ($currSesh > $newestSesh) {
                            $newestSesh = $currSesh;
                        }
                    }
                    if ($newestSesh !== date('d-m-Y', 0)) {
                        echo $newestSesh;
                    } else {
                        echo 'an imaginary time';
                    }
                }
                ?>. Click <a href=sessionHistory.php>here</a> to see more information.
            </p>
            <p>
                <?php
                if ($type != 'tutor') {
                    echo (count($dao->getMessages($email)[0][0]) != 0) ? 'Check out all messages <a href=message.php>here</a>' : 'You don\'t have any messages';
                } else {
                    $emails = $dao->getStudentEmails($dao->getTutorNumber($email));
                    if (count($emails) == 0) {
                        echo "You have no students, which means no messages!" . nl2br("\r\n");
                    }
                    $hasM = false;
                    foreach ($emails as $e) {
                        if (count($dao->getMessages($e[0])) != 0) {
                            $hasM = true;
                            echo 'Check out all messages <a href=message.php>here</a>';
                            break;
                        }
                    }
                    if ($hasM == false) {
                        echo 'No one sent messages to you; you are unloved.';
                    }
                }
                ?>
            </p>
            <p>
                <?php
                $nextSesh = $dao->getNextSession($dao->getTutorNumber($email));
                echo 'Next Tutor Session: ';
                echo (($nextSesh != '') ? $nextSesh : 'TBD');
                echo nl2br("\r\n");
                ?>
            </p>
            <?php if ($type == 'tutor') { 
                $today = date('Y-m-d', strtotime(' - 1 days'));
                ?>
                <p>
                <form method="POST" action="nextDateHandler.php">
                    To set your next session date so students can see, use the calendar below:
                    <p>
                        <input type="date" name="date" min="<?php echo $today ?>" class="<?php echo classSet('date') ?>"
                            value="<?php echo seshSet('date') ?>"><?php echo dot('date') ?>
                            <input type="submit" value="Set My Next Session Date!">
                    <p>
                </form>
                </p>
            <?php } ?>
            <p>
            <form action="homeMHandler.php">
                To logout and return to the login page, click <input type="submit" value="here">
            </form>
            Or, you can simply visit a non-member page to logout.
            </p>
        </div>
        <?php include("footer.php"); ?>
    </div>
    </body>

    </html>