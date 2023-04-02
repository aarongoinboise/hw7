<?php

session_start();
require_once 'Dao.php';
require_once 'KLogger.php';
require_once 'saveFormTxt.php';
$logger = new KLogger("log.txt", KLogger::DEBUG);
$_SESSION['red'] = $_POST;
$_SESSION['inputs'] = $_POST;
$type = $_SESSION['mType'];
$sessionOrPrac = $_SESSION['select'];
$dao = new Dao();
$email = $_SESSION['userEmail'];

$wrongAns1 = $_POST['wrongAns1'];
if ($wrongAns1 != '') {
    unset($_SESSION['red']['wrongAns1']);
}
$wrongAns2 = $_POST['wrongAns2'];
if ($wrongAns2 != '') {
    unset($_SESSION['red']['wrongAns2']);
}
$rightAns = $_POST['rightAns'];
if ($rightAns != '') {
    unset($_SESSION['red']['rightAns']);
}
$descQ = $_POST['descQ'];
if ($descQ != '') {
    unset($_SESSION['red']['descQ']);
}
$date = $_POST['date'];
if ($date != '') {
    unset($_SESSION['red']['date']);
}

if ($type == 'tutor') {
    $email = $_POST['email'];
    /* email regex */
    $regex = "/.+@.+\..+/";
    if (preg_match($regex, $email) != 1) {
        // unset($_SESSION['red']);
        $_SESSION['red']['email'] = 'set';
        if ($sessionOrPrac == 'session') {
            if (($descQ == '' || $date == '') && $email == '') {
                err("Email doesn't fit pattern and date and blank", "Please fill out everything", 'edit.php?select=' . $sessionOrPrac);
            } else {
                if (($descQ == '' || $date == '') && $email != '') {
                    err("Email doesn't fit pattern and date", "Please fill out everything/email does not exist", 'edit.php?select=' . $sessionOrPrac);
                } else {
                    err("Email doesn't fit pattern and date", "Email does not exist", 'edit.php?select=' . $sessionOrPrac);
                }
            }
        } else {
            if ($descQ == '' || $wrongAns1 == '' || $wrongAns2 == '' || $rightAns == '') {
                if ($email == '') {
                    err("Email doesn't fit pattern", "Please fill out everything", 'edit.php?select=' . $sessionOrPrac);
                } else {
                    err("Email doesn't fit pattern", "Please fill out everything/email does not exist", 'edit.php?select=' . $sessionOrPrac);
                }
            } else {
                if ($email == '') {
                    err("Email doesn't fit pattern", "Please enter an email", 'edit.php?select=' . $sessionOrPrac);
                }
                err("Email doesn't fit pattern", "Email does not exist", 'edit.php?select=' . $sessionOrPrac);
            }
        }
    }
    $tEmail = $_SESSION['userEmail'];
    /* Check if student belongs to tutor*/
    if ($dao->checkStudentBelongsToTutor($email, $tEmail) != 1) {
        // unset($_SESSION['red']);
        $_SESSION['red']['email'] = 'set';
        if (($descQ == '' || $date == '')) {
            err($email . " and " . $tEmail . " are not related", 'Please fill out everything/Student email isn\'t registered with you', 'edit.php?select=' . $sessionOrPrac);
        } else {
            err($email . " and " . $tEmail . " are not related", 'Student email isn\'t registered with you', 'edit.php?select=' . $sessionOrPrac);
        }
    }
    unset($_SESSION['red']['email']);
} // end of tutor checks

if ($descQ == '') {
    if ($date == '' && $sessionOrPrac == "session") {
        err("desQ and date are blank", "Please make sure description and date are filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
    } else {
        if ($sessionOrPrac == "session") {
            err("desQ is blank", "Please make sure description is filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
        } else {
            if ($wrongAns1 == '' || $wrongAns2 == '' || $rightAns == '') {
                err("stuff blank", "Please make sure the question and answers are filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
            } else {
                err("desQ is blank", "Please make sure the question is filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
            }
        }
    }
}
if(($sessionOrPrac == "practice") && ($wrongAns1 == '' || $wrongAns2 == '' || $rightAns == '')) {
    err("stuff besides q is blank", "Please make sure the answers are filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
}

if ($sessionOrPrac == "session") {
    if ($date == '') {
        err("session date is blank", "Please make sure the date is filled out before signing up", 'edit.php?select=' . $sessionOrPrac);
    }

    /* Insert session */
    if ($dao->checkSessionDate($date) > 0) {
        $sH = $dao->getSessionHistory($email);
        for ($x = 0; $x < count($sH); $x++) {
            if ($sH[$x][0] == $date) {
                if ($sH[$x][1] == $descQ) {
                    $_SESSION['red'] = $_POST;
                    err("editPrac matching session history", 'Description is the same for the specified date', 'edit.php?select=' . $sessionOrPrac);
                }
            }
        }
        $dao->updateSession($descQ, $date);
    } else if ($dao->saveSession($email, $date, $descQ) != 2) {
        err("editSession parameter is too long", 'email or description is too long', 'edit.php?select=' . $sessionOrPrac);
    }


} else {
    /* Insert practice */
    if ($dao->checkPractice($email) == 1) {
        $p = $dao->getPractice($email);
        if ($p[0][0] == $descQ && $p[0][1] == $wrongAns1 && $p[0][2] == $wrongAns2 && $p[0][3] == $rightAns) {
            $_SESSION['red'] = $_POST;
            err("editPrac question is the same", 'Everything matches your current question/options', 'edit.php?select=' . $sessionOrPrac);
        }
        $pID = $dao->getPID($email);
        $dao->savePractice($email, $descQ, $wrongAns1, $wrongAns2, $rightAns);
        $dao->deletePractice($pID);
    } else {
        $dao->savePractice($email, $descQ, $wrongAns1, $wrongAns2, $rightAns);
    }
}

/* Final redirect after insertions */
$_SESSION['message'] = 'Success! You have edited your ' . $sessionOrPrac . '!';
header("Location: edit.php?select=" . $sessionOrPrac);
exit();