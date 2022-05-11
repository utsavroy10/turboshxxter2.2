<?php
//version 1.0
$querySentTable = "insert into reports_table select email,flag,domain_id,curdate() from ".$_SESSION['table']."";

$querySentTableEX = mysqli_query($con, $querySentTable);

$deleteReports = "delete from reports_table where sent_date < (curdate() - INTERVAL 45 DAY)";

$deleteReportsEX = mysqli_query($con, $deleteReports);

?>