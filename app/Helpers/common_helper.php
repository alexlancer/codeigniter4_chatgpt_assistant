<?php
function ajaxData(bool $error, array|\stdClass $data = [], string $msg = '')
{
  return [
    'error' => $error,
    'data' => $data,
    'message' => $msg,
  ];
}

function invalidJson($string)
{
  json_decode($string);
  $error = json_last_error();
  return $error === JSON_ERROR_NONE ? false : $error;
}
