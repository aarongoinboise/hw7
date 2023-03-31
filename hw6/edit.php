<?php
include("memberIncludesReqs.php");
if (isset($_SESSION['mType'])) {
    $type = $_SESSION['mType'];
} else {
    err("Attempt to access edit w/out login", 'Please login to edit sessions or questions', 'signin.php');
}

?>
<h1>Add a Session/Practice Question</h1>
</div>
<div id="menuBarFiveCol" class="menuBar">
    <?php
    $_POST['selected'] = 'edit';
    include("menu.php");
    unset($_POST['selected']);
    $email = $_SESSION['userEmail'];
    ?>
    <div id="<?php echo $type == 'tutor' ? 'tutorBackgroundPic' : 'studentBackgroundPic' ?>"
        class="backgroundPicFormat">
        <?php include("formM.php");
        ?>
        <div id="formText">
            <form method="GET" id="formType">
                Would you like to add/edit a session or a pratice event?
                <select required form="formType" name="select" onchange="this.form.submit()">
                    <option value="" hidden>Type of Edit</option>
                    <option value="session" <?php echo findSelectedOptE('session') ?>>Session</option>
                    <option value="practice" <?php echo findSelectedOptE('practice') ?>>Practice</option>
                </select>
            </form>
            <?php if (isset($_GET['select']) || isset($_SESSION['select'])) {
                if (isset($_GET['select'])) {
                    $_SESSION['select'] = $_GET['select'];
                }
                ?>
                <form method="POST" name="opts" action="editHandler.php">
                    <p>
                        <?php if ($type == 'tutor') {
                            ?> Enter the student email:
                            <input class="<?php echo classSet('email') ?>" type="text" name="email"
                                value="<?php echo seshSet('email') ?>" placeholder="ex: email@provider.net"><?php echo dot('email') ?>
                        <?php } ?>
                    </p>
                    <?php $labels;
                    $placeholders;
                    $sessionOrPrac = isset($_POST['select']) ? $_POST['select'] : $_SESSION['select'];
                    if ($sessionOrPrac == "session") {
                        $labels = array("brief description", "the date");
                        $placeholder = "brief description";
                    } else {
                        $labels = array("question", "two wrong answers and one right answer");
                        $placeholder = "ex: What is 2+2?";
                    } ?>
                    <p>
                        Enter a
                        <?php echo $labels[0] ?>:
                        <input class="<?php echo classSet('descQ') ?>" type="text" name="descQ"
                            value="<?php echo seshSet('descQ') ?>" placeholder="<?php echo $placeholder ?>"><?php echo dot('descQ') ?>
                    </p>
                    <p>
                        Enter
                        <?php echo $labels[1] ?>:
                        <?php if ($sessionOrPrac == "session") { ?>
                            <input type="date" name="date" min="2023-01-01" class="<?php echo classSet('date') ?>"
                                value="<?php echo seshSet('date') ?>"><?php echo dot('date') ?>
                        <?php } else { ?>
                        <p>
                            Wrong Answer 1:
                            <input class="<?php echo classSet('wrongAns1') ?>" type="text" name="wrongAns1"
                                value="<?php echo seshSet('wrongAns1') ?>" placeholder="ex for 2+2: 2"><?php echo dot('wrongAns1') ?>
                        </p>
                        <p>
                            Wrong Answer 2:
                            <input class="<?php echo classSet('wrongAns2') ?>" type="text" name="wrongAns2"
                                value="<?php echo seshSet('wrongAns2') ?>" placeholder="ex for 2+2: 3"><?php echo dot('wrongAns2') ?>
                        </p>

                        Right Answer:
                        <input class="<?php echo classSet('rightAns') ?>" type="text" name="rightAns"
                            value="<?php echo seshSet('rightAns') ?>" placeholder="ex for 2+2: 4"><?php echo dot('rightAns') ?>

                        <?php
                        }
                        ?>
                    </p>
                    <p>
                        Note: If a practice question or session exists on the specified date, it will be overwritten.
                    </p>
                    <p>
                    <div><input type="submit" value="Submit!"></div>
                    </p>
                    <?php
            }
            ?>
        </div>
        </form>
        <?php include("footer.php"); ?>
    </div>
    </body>

    </html>