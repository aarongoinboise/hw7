<?php
function seshSet($prevS)
{
    if (isset($_SESSION['inputs'][$prevS])) {
        $prevInput = $_SESSION['inputs'][$prevS];
    } else {
        $prevInput = '';
    }
    $regex = "/\d-\d-\d{4}/";
    if (preg_match($regex, $prevInput) == 1) {
        return $prevInput;
    }
    return htmlspecialchars($prevInput);
}

function classSet($prevS)
{
    if (isset($_SESSION['red'][$prevS])) {
        return "textErr";
    }
    return '';
}
function err($logM, $sessionM, $headerL)
{
    $_SESSION['message'] = $sessionM;
    header("Location: {$headerL}");
    exit();
}

function findSelectedOptE($opt)
{
    if (($_GET['select'] == 'session') && $opt == 'session') {
        return 'selected';
    }
    if (($_GET['select'] == 'practice') && $opt == 'practice') {
        return 'selected';
    }
    return '';
}

function findSelectedOptSE($opt)
{
    if (($_SESSION['emailS'] == $opt)) {
        return 'selected';
    }
    return '';
}

function dot($opt)
{
    if (isset($_SESSION['red'][$opt])) {
        return '&#x1f534';
    }
    return '';
}

function findSelectedOptFP($opt)
{
    if (($_GET['select'] == 'student') && $opt == 'student') {
        return 'selected';
    }
    if (($_GET['select'] == 'you') && $opt == 'you') {
        return 'selected';
    }
    return '';
}

function findRadioBtnSelect($opt) {
    if ($_SESSION['inputs']['opt'] == $opt) {
        return 'checked';
    }
    return '';
}