<?php
$status = array();
if($user_ok){
  $status['login'] = 1;
}else{
  $status['login'] = 0;
}

echo json_encode($status);
die;
