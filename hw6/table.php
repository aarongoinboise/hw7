<?php
require_once 'KLogger.php';
require_once("Dao.php");
$logger = new KLogger("log.txt", KLogger::DEBUG);

class table
{

  public static function renderSessionTableStudent($sessionHistory)
  {
    if (count($sessionHistory) == 0) {
      return "<tr> <td>" . "No sessions exist!" . "</td> </tr>";
    }
    $dao = new Dao();
    $html = "";
    for ($x = 0; $x < count($sessionHistory); $x++) {
      $id = $dao->getSessionId($sessionHistory[$x][0]);
      $html .= "<tr>";
      $html .= "<td>" . htmlspecialchars($sessionHistory[$x][0]) . "</td>"; // date 
      $html .= "<td>" . htmlspecialchars($sessionHistory[$x][1]) . "</td>"; // description 
      $html .= "<td id=\"delete\"><a href='deleteHandlerSH.php?id={$id}'>X</a></td>";
      $html .= "</tr>";
    }
    return $html;
  }

  public static function renderMessageTableStudent($messages, $email)
  {
    if (count($messages) == 0) {
      return "<tr> <td>" . "No messages exist!" . "</td> </tr>";
    }
    $dao = new Dao();
    $html = "";
    for ($x = 0; $x < count($messages); $x++) {
      $html .= "<tr>";
      if ($messages[$x][0] == 1) {// student sent it
        $from = "YOU";
      } else {// tutor sent it
        $from = $dao->getTutorFromStudent($email);
      }
      $html .= "<td>" . htmlspecialchars($from) . "</td>"; // studentSessionMessage
      $html .= "<td>" . htmlspecialchars($messages[$x][1]) . "</td>"; // m_date
      $html .= "<td>" . htmlspecialchars($messages[$x][2]) . "</td>"; // m_description
      $html .= "</tr>";
    }
    return $html;
  }

  public static function renderTableTop()
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "<th id=\"delete\">Delete</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }

  public static function renderTableTopNoDelete()
  {
    $html .= "<table>";
    $html .= "<thead>";
    $html .= "<tr>";
    $html .= "<th>From</th>";
    $html .= "<th>Date</th>";
    $html .= "<th>Description</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    return $html;
  }
}