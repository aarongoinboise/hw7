<?php
include("titlefab.php");
include("h1s.php");
?>
<h1>Messages</h1>
</div>
<?php
$_POST['selected'] = 'tutorMessage';
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
        <p>
            Today's Date: xx/xx/2023
        </p>
        <p>
            Write a brief message to send to a student below:
        </p>
        <p>
            <input type="text" id="UserName" name="UserName" placeholder="Student UserName">
        </p>
        <p>
            <input type="text" id="Message" name="Message" placeholder="Message">
        </p>
        <p>
            <button type="button" onclick="alert('Your message has been sent!')">Send Message</button>
        </p>
        <p>
            To see newest messages click <a href=tutorMessage.php>here</a>
        </p>
        <?php include("footer.php"); ?>
    </div>
    </body>

    </html>