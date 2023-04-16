<?php
require_once 'KLogger.php';
require_once("Dao.php");
$logger = new KLogger("log.txt", KLogger::DEBUG);

class table
{

  public static function renderSessionTableStudent($sessionHistory, $tutor)
  {
    if (count($sessionHistory) == 0) {
      return "<tr> <td>" . "No sessions exist!" . "</td> </tr>";
    }
    $dao = new Dao();
    $html = "";
    for ($x = 0; $x < count($sessionHistory); $x++) {
      $html .= "<tr>";
      $html .= "<td>" . htmlspecialchars($sessionHistory[$x][0]) . "</td>"; // date 
      $html .= "<td>" . htmlspecialchars($sessionHistory[$x][1]) . "</td>"; // description 
      if ($tutor) {
        $id = $dao->getSessionId($sessionHistory[$x][0]);
        $html .= "<td id=\"delete\"><a href='deleteHandlerSH.php?id={$id}'>X</a></td>";
      }
      $html .= "</tr>";
    }
    return $html;
  }

  public static function renderMessageTableStudent($messages, $sEmail, $tEmail, $tutor)
  {
    if (count($messages) == 0) {
      return "<tr> <td>" . "No messages exist!" . "</td> </tr>";
    }
    $html = "";
    for ($x = 0; $x < count($messages); $x++) {
      $html .= "<tr>";
      if ($messages[$x][0] == 1) { // student sent it
        // $fromTo = '<p>' . htmlspecialchars($tEmail) . '</p>' . htmlspecialchars($sEmail);
        $html .= "<td>" . htmlspecialchars($tEmail) . "</td>";
        $html .= "<td>" . htmlspecialchars($sEmail) . "</td>";
      } else { // tutor sent it
        // $fromTo = '<p>' . htmlspecialchars($sEmail) . '</p>' . htmlspecialchars($tEmail);
        $html .= "<td>" . htmlspecialchars($sEmail) . "</td>";
        $html .= "<td>" . htmlspecialchars($tEmail) . "</td>";
      }
      // $html .= "<td>" . $fromTo . "</td>"; // studentSessionMessage
      $html .= "<td>" . htmlspecialchars($messages[$x][1]) . "</td>"; // m_date
      $html .= "<td>" . htmlspecialchars($messages[$x][2]) . "</td>"; // m_description
      if ($tutor) {
        $dao = new Dao();
        $id = $dao->getMessageId($messages[$x][1]);
        $html .= "<td id=\"delete\"><a href='deleteHandlerM.php?id={$id}'>X</a></td>";
      }
      $html .= "</tr>";
    }
    return $html;
  }

  public static function renderPracticeTableStudent($email, $practice, $opt1, $opt2, $opt3)
  {
    if (count($practice) == 0) {
      return "<tr> <td>" . "No practice questions exist!" . "</td> </tr>";
    }
    $html = "";
    $html .= "<tr>";
    $html .= "<td>" . htmlspecialchars($practice[0][0]) . "</td>"; // question
    $html .= "<td>" . htmlspecialchars($opt1) . "</td>"; // opt 1
    $html .= "<td>" . htmlspecialchars($opt2) . "</td>"; // opt 2
    $html .= "<td>" . htmlspecialchars($opt3) . "</td>"; // opt 3
    $html .= "</tr>";
    return $html;
  }

  public static function renderPracticeTableStudentT($email, $practice, $opt1, $opt2, $opt3)
  {
    if (count($practice) == 0) {
      return "<tr> <td>" . "No practice questions exist!" . "</td> </tr>";
    }
    $html = "";
    $html .= "<tr>";
    $html .= "<td>" . htmlspecialchars($practice[0][0]) . "</td>"; // question
    $html .= "<td>" . htmlspecialchars($opt1) . "&#10060;" . "</td>"; // wrong
    $html .= "<td>" . htmlspecialchars($opt2) . "&#10060;" . "</td>"; // wrong
    $html .= "<td>" . htmlspecialchars($opt3) . "&#9989;" . "</td>"; // correct
    $html .= "</tr>";
    return $html;
  }

  public static function renderTableTopSH($email)
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr><th id=\"underline\">{$email}</th><th></th><th></th></tr>";
    $html .= "<tr>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "<th id=\"delete\">Delete</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

  public static function renderTableTopSHNoDelete($email)
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr><th id=\"underline\">{$email}</th><th></th></tr>";
    $html .= "<tr>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

  public static function renderTableTopM($email)
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr><th id=\"underline\">{$email}</th><th></th><th></th><th></th><th></th></tr>";
    $html .= "<tr>";
    $html .= "<th>To</th>";
    $html .= "<th>From</th>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "<th id=\"delete\">Delete</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

  public static function renderTableTopMNoDelete($email)
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr><th id=\"underline\">{$email}</th><th></th><th></th><th></th></tr>";
    $html .= "<tr>";
    $html .= "<th>To</th>";
    $html .= "<th>From</th>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

  public static function renderTableTopP($email)
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr><th id=\"underline\">{$email}</th><th></th><th></th><th></th></tr>";
    $html .= "<tr><th>Question</th>";
    $html .= "<th>Option 1</th>";
    $html .= "<th>Option 2</th>";
    $html .= "<th>Option 3</th></tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

}