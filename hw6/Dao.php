<?php
require_once 'KLogger.php';

/**
 * Summary of Dao
 */
class Dao
{

    private $host = "127.0.0.1";
    private $port = "8889";
    private $db = "aarongoin";
    private $user = "aarongoin";
    private $pass = "Pizzaguy1!";

    public function getConnection()
    {
        return new PDO(
            "mysql:host={$this->host};port={$this->port};dbname={$this->db}", $this->user,
            $this->pass
        );
    }

    public function saveUser($pass, $email, $hint)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO user
            (email, password, hint, access)
            VALUES
            (:email, :pass, :hint, 1)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":email", $email);
        $q->bindParam(":pass", $pass);
        $q->bindParam(":hint", $hint);
        $q->execute();
        return $conn->lastInsertId();
    }

    public function saveStudent($u_id, $t_id)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO student
            (u_id, t_id)
            VALUES
            (:u_id, :t_id)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":u_id", $u_id);
        $q->bindParam(":t_id", $t_id);
        $q->execute();
    }

    public function saveTutor($u_id)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO tutor
            (u_id)
            VALUES
            (:u_id)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":u_id", $u_id);
        $q->execute();
        return $conn->lastInsertId();
    }

    public function saveSession($email, $date, $desc) // sessionHistories and studentSessions (two ids)
    {
        $student_id = Dao::getSID($email);

        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO sessionHistories
            (s_date, s_description)
            VALUES
            (:date, :desc)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":date", $date);
        $q->bindParam(":desc", $desc);
        $q->execute();
        $rCntOne = $q->rowCount();
        if ($rCntOne != 1) {
            return 0;
        }

        $session_id = $conn->lastInsertId();
        $saveQuery =
            "INSERT INTO studentSessions
            (student_id, session_id)
            VALUES
            ($student_id, $session_id)";
        $rCntTwo = $conn->query($saveQuery)->rowCount();

        $ret = $rCntTwo + $rCntOne;
        return $ret;
    }

    public function savePractice($email, $question, $opt1, $opt2, $opt3) // practice and update student
    {
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO practice
            (practiceQuestion, wrongOption1, wrongOption2, rightOption)
            VALUES
            (:question, :opt1, :opt2, :opt3)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":question", $question);
        $q->bindParam(":opt1", $opt1);
        $q->bindParam(":opt2", $opt2);
        $q->bindParam(":opt3", $opt3);
        $q->execute();
        $p_id = $conn->lastInsertId();
        $s_id = Dao::getSID($email);
        $saveQuery =
            "UPDATE student
            SET p_id = $p_id
            WHERE id = $s_id";
        $conn->query($saveQuery);
    }

    public function saveMessage($m_description, $studentSent, $email)
    {
        $s_id = Dao::getSID($email);
        $conn = $this->getConnection();
        $saveQuery =
            "INSERT INTO messages
            (m_date, m_description, studentSentMessage)
            VALUES
            (now(), :m_description, :studentSent)";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":m_description", $m_description);
        $q->bindParam(":studentSent", $studentSent);
        $q->execute();
        $rCntOne = $q->rowCount();
        if ($rCntOne != 1) {
            return 0;
        }

        $m_id = $conn->lastInsertId();
        $saveQuery =
            "INSERT INTO studentMessages
            (s_id, m_id)
            VALUES
            ($s_id, $m_id)";
        $rCntTwo = $conn->query($saveQuery)->rowCount();

        $ret = $rCntTwo + $rCntOne;
        return $ret;
    }

    public function saveNextSesh($date, $t_id)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "UPDATE tutor
            SET nextSesh = :date
            WHERE id = $t_id";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":date", $date);
        $q->execute();
    }

    public function getSID($email)
    {
        $conn = $this->getConnection();
        $selectQuery =
            "SELECT s.id
            FROM student s
            JOIN user u ON s.u_id=u.id
	        WHERE u.email = :email";
        $q = $conn->prepare($selectQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

    public function checkPractice($email)
    {
        $conn = $this->getConnection();
        $s_id = Dao::getSID($email);
        $saveQuery =
            "SELECT *
            FROM student
            WHERE id = $s_id
            AND p_id <> 'NULL'";
        $q = $conn->prepare($saveQuery);
        $q->execute();
        $rCnt = $q->rowCount();
        return $rCnt;
    }

    public function checkUser($email)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT *
            FROM user
            WHERE email=:email";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $rCnt = $q->rowCount();

        // global $logger;
        // $logger->LogDebug("email:{$email} rowCnt: {$rCnt}");

        return $rCnt;
    }

    public function checkTutorNumber($tNum)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT id
            FROM tutor
            WHERE id=:tNum";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":tNum", $tNum);
        $q->execute();
        $rCnt = $q->rowCount();

        // global $logger;
        // $logger->LogDebug("tutor num:{$tNum} rowCnt: {$rCnt}");

        return $rCnt;
    }

    public function checkPassword($email, $pass)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT *
            FROM user
            WHERE email=:email
            AND password=:pass";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":email", $email);
        $q->bindParam(":pass", $pass);
        $q->execute();
        $rCnt = $q->rowCount();

        // global $logger;
        // $logger->LogDebug("email: {$email} pass: {$pass}, and rCnt: {$rCnt}");

        return $rCnt;
    }

    public function checkTutorFromEmail($email)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT user.email
            FROM tutor
            JOIN user ON tutor.u_id = user.id
            WHERE user.email = :email";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $rCnt = $q->rowCount();

        // global $logger;
        // $logger->LogDebug("(tutorFromEmail) email: {$email} and rCnt: {$rCnt}");

        return $rCnt;
    }

    public function checkStudentBelongsToTutor($sEmail, $tEmail)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT u.email
            FROM tutor t
            JOIN student s ON t.id=s.t_id
	        JOIN user u ON s.u_id=u.id
	        WHERE t.id = (
	            SELECT t.id
	            FROM tutor t
	            JOIN user u ON t.u_id = u.id
	            WHERE email = :tEmail
	        )
	        AND s.id = (
	            SELECT s.id
	            FROM student s
	            JOIN user u ON s.u_id = u.id
	            WHERE email = :sEmail
	        )";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":sEmail", $sEmail);
        $q->bindParam(":tEmail", $tEmail);
        $q->execute();
        $rCnt = $q->rowCount();

        // global $logger;
        // $logger->LogDebug("(student belongs tutor) sEmail: {$sEmail} tEmail: {$tEmail} and rCnt: {$rCnt}");

        return $rCnt;
    }

    public function checkSessionDate($sDate)
    {
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT *
            FROM sessionHistories
            WHERE s_date = :sDate";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":sDate", $sDate);
        $q->execute();
        return $q->rowCount();
    }

    public function resetPassword($email, $newPassword)
    {
        $conn = $this->getConnection();
        $updateQuery =
            "UPDATE user
            SET password=:newPassword
            WHERE email=:email";
        $q = $conn->prepare($updateQuery);
        $q->bindParam(":email", $email);
        $q->bindParam(":newPassword", $newPassword);
        $q->execute();
        return $q->rowCount();
    }

    public function updateSession($newDesc, $sDate)
    {
        $conn = $this->getConnection();
        $updateQuery =
            "UPDATE sessionHistories
            SET s_description=:newDesc
            WHERE s_date=:sDate";
        $q = $conn->prepare($updateQuery);
        $q->bindParam(":newDesc", $newDesc);
        $q->bindParam(":sDate", $sDate);
        $q->execute();
    }

    public function deleteMessage($id)
    {
        $conn = $this->getConnection();
        $deleteQuery =
            "DELETE FROM studentMessages
            WHERE m_id=:id";
        $q = $conn->prepare($deleteQuery);
        $q->bindParam(":id", $id);
        $q->execute();
        $deleteQuery =
            "DELETE FROM messages
            WHERE id=:id";
        $q = $conn->prepare($deleteQuery);
        $q->bindParam(":id", $id);
        $q->execute();
    }

    public function deleteSession($id)
    {
        $conn = $this->getConnection();
        $deleteQuery =
            "DELETE FROM studentSessions
            WHERE session_id=:id";
        $q = $conn->prepare($deleteQuery);
        $q->bindParam(":id", $id);
        $q->execute();
        $deleteQuery =
            "DELETE FROM sessionHistories
            WHERE id=:id";
        $q = $conn->prepare($deleteQuery);
        $q->bindParam(":id", $id);
        $q->execute();
    }

    public function deletePractice($id)
    {
        global $logger;
        $conn = $this->getConnection();
        $deleteQuery =
            "DELETE FROM practice
            where id=:id";
        $logger->LogDebug("dao dP dQ: {$deleteQuery}");
        $q = $conn->prepare($deleteQuery);
        $q->bindParam(":id", $id);
        $q->execute();
    }

    public function getPID($email)
    {
        $id = Dao::getSID($email);
        $conn = $this->getConnection();
        $saveQuery =
            "SELECT p_id
            FROM student
            WHERE id = :id";
        $q = $conn->prepare($saveQuery);
        $q->bindParam(":id", $id);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }


    public function getPassword($email)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT user.password
            FROM user
            WHERE email=:email";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ret = $q->fetchColumn();

        // global $logger;
        // $logger->LogDebug("(getSPass) email: {$email} and return val: {$ret}");

        return $ret;
    }

    public function getHint($email)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT user.hint
            FROM user
            WHERE email=:email";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ret = $q->fetchColumn();

        // global $logger;
        // $logger->LogDebug("(getHint) email: {$email} and return val: {$ret}");

        return $ret;
    }

    public function getTutorNumber($email)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT tutor.id
            FROM user
            JOIN tutor ON user.id = tutor.u_id
            WHERE user.email = :email";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":email", $email);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        $ret = $q->fetchColumn();

        // global $logger;
        // $logger->LogDebug("(getTutorNumber) email: {$email} and return val: {$ret}");

        return $ret;
    }

    public function getTutorEmailFromStudent($sEmail)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT u.email
            FROM user u
            JOIN tutor t ON u.id = t.u_id
            WHERE t.id = (
                SELECT s.t_id
                FROM user u
                JOIN student s ON u.id = s.u_id
                WHERE u.email = :sEmail
            )";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":sEmail", $sEmail);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

    public function getLastSession($sEmail)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT MAX(s_date)
            FROM sessionHistories sH
	        JOIN studentSessions sS ON sH.id = sS.session_id
            WHERE sS.student_id = (
                SELECT s.id
                FROM student s
                JOIN user u ON s.u_id = u.id
                WHERE u.email = :sEmail
            );";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":sEmail", $sEmail);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

    public function getStudentEmails($t_id)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT u.email
            FROM tutor t
            JOIN student s ON t.id=s.t_id
	        JOIN user u ON s.u_id=u.id
	        WHERE t.id = :t_id";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":t_id", $t_id);
        $q->execute();
        return $q->fetchAll();
    }

    public function getSessionHistory($sEmail)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT sH.s_date, sH.s_description
            FROM user u
            JOIN student s ON u.id = s.u_id
            JOIN studentSessions sS ON s.id = sS.student_id
            JOIN sessionHistories sH ON sS.session_id = sH.id
            WHERE u.email = :sEmail
            ORDER BY sH.s_date DESC";

        $q = $conn->prepare($returnQuery);
        $q->bindParam(":sEmail", $sEmail);
        $q->execute();
        return $q->fetchAll();
    }

    public function getPractice($sEmail) {
        $conn = $this->getConnection();
        $id = Dao::getPID($sEmail);
        $returnQuery =
            "SELECT p.practiceQuestion, p.wrongOption1, p.wrongOption2, p.rightOption
            FROM user u
            JOIN student s ON u.id = s.u_id
            JOIN practice p ON s.p_id = p.id
            WHERE p.id = :id";

        $q = $conn->prepare($returnQuery);
        $q->bindParam(":id", $id);
        $q->execute();
        return $q->fetchAll();
    }

    public function getMessages($sEmail)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT m.studentSentMessage, m.m_date, m.m_description
            FROM user u
            JOIN student s ON u.id = s.u_id
            JOIN studentMessages sM ON s.id = sM.s_id
            JOIN messages m ON sM.m_id = m.id
            WHERE u.email = :sEmail
            ORDER BY m.m_date DESC";

        $q = $conn->prepare($returnQuery);
        $q->bindParam(":sEmail", $sEmail);
        $q->execute();
        return $q->fetchAll();
    }

    public function getSessionId($date)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT id
            FROM sessionHistories
            WHERE s_date = :date";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":date", $date);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

    public function getMessageId($date)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT id
            FROM messages
            WHERE m_date = :date";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":date", $date);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

    public function getNextSession($id)
    {
        $conn = $this->getConnection();
        $returnQuery =
            "SELECT nextSesh
            FROM tutor
            WHERE id = :id";
        $q = $conn->prepare($returnQuery);
        $q->bindParam(":id", $id);
        $q->execute();
        $q->setFetchMode(PDO::FETCH_ASSOC);
        return $q->fetchColumn();
    }

} // end Dao