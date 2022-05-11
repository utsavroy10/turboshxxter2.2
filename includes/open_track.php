<?php
//Version 1.0
include_once('dbcon.php');
$query = "update revamp_reports set open_flag=open_flag + 1 , open_date=now() where email='".$_GET['email']."' and user_id='".$_GET['user_id']."' and sent_date like '".$_GET['date']."%'";
            $result = mysqli_query($con, $query);
?>