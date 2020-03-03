<?php

// generate response msg to send
function responseMessage($responseData = array(), $status = 0, $logResponse = array())
{
  // If array
  if (isNonEmptyArray($responseData)) {
    $message = $responseData["message"] ? $responseData["message"] : "";
    $response = $responseData["data"] ? $responseData["data"] : "";
  } else {
    $message = $responseData;
    $response = "";
  }

  $statusArr = array(
    0 => constant('FAILED'),
    1 => constant('SUCCESS'),
    2 => constant('WARNING'),
  );

  $arrMsg = array(
    "status" => $statusArr[$status],
    "message" => $message,
    "data" => $response,
  );

  header('Content-Type: application/json');
  echo $res = json_encode($arrMsg);

  if ($logResponse && $logResponse["log"]) {
    debug_log($res, $logResponse["fileName"], $logResponse["folderName"] ? $logResponse["folderName"] : "");
  }
}

// create log
function debug_log($stringData, $fileName = "logfile", $logFolderName = "", $logDirectory = "")
{
  global $VMP_AB_PATH;

  $timezone = new DateTimeZone("Asia/Calcutta");
  $date = new DateTime();
  $date->setTimezone($timezone);

  $cdate = $date->format("Y-m-d");

  $Directory = $logDirectory ? $logDirectory : $VMP_AB_PATH . "/logs_data/" . $cdate . $logFolderName;

  if ($Directory && !file_exists($Directory)) {
    mkdir($Directory, 0777, true);
  }

  $myFile = $Directory . "/" . $fileName . ".txt";
  $fh = fopen($myFile, 'a');
  fwrite($fh, $stringData);
  fwrite($fh, "\r\n");
  fclose($fh);
}

// filters
//Check if variable is defined and not null
function isDefined($var)
{
  return isset($var);
}

//Check if string is empty
function isEmptyString($str)
{
  return isDefined($str) && is_string($str) && $str === '';
}

//Check if value is true
function isNonEmpty($value)
{
  //false values are "", 0, 0.0, "0", NULL, FALSE, [], $var (a variable declared, but without a value)
  return isDefined($value) && !empty($value);
}

//Check if array is not empty
function isNonEmptyArray($arr)
{
  return isNonEmpty($arr) && is_array($arr);
}
