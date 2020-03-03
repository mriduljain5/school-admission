<?php

require_once("./includes/index.php");

$jsondata = file_get_contents("php://input");
$arrJsonData = json_decode($jsondata, true);

$arrBoard = array(1 => "CBSE", 2 => "CISCE");
$arrMedium = array(1 => "English", 2 => "Hindi");

$board = isset($arrJsonData["board"]) ? $arrBoard[$arrJsonData["board"]] : "";
$medium = isset($arrJsonData["medium"]) ? $arrMedium[$arrJsonData["medium"]] : "";

$sCond = "";
if ($board) {
  $sCond = "WHERE school_board = '$board'";
}
if ($medium) {
  if ($sCond) {
    $sCond .= " AND school_medium = '$medium'";
  } else {
    $sCond = "WHERE school_medium = '$medium'";
  }
}

$res = null;
$rows = 0;
$query = "SELECT school_name, school_board, school_medium, school_address FROM tblschool $sCond";
$dbConn->ExecuteSelectQuery($query, $res, $rows);

$arrData = array();
if ($rows > 0) {
  while ($row = $dbConn->GetData($res)) {
    $arrData[] = array(
      "school_name" => $row["school_name"],
      "school_board" => $row["school_board"],
      "school_medium" => $row["school_medium"],
      "school_address" => $row["school_address"],
    );
  }
}

responseMessage(array("message" => null, "data" => $arrData), 1);
