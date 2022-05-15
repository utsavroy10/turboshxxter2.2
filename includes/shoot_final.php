<!doctype html>
<?php //Version 2.0 ?>
<html lang="en">
    
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Turbo Shxxter</title>
  </head>
  <body>


<?php
$con = mysqli_connect('localhost', 'u915573196_shxxter', 'Turboisbest@1', 'u915573196_turbo');
if(!$con){
    die("Connection Failed");
}
?>
<?php


session_start();

if (!isset($_SESSION['domain'])) {
    

    
    if (isset($_POST['fire'])) {

        $d_id = $_POST['d_id'];
        $table = $_POST['table'];
        $templatz = $_POST['templatz'];
        
        $subject = $_POST['subject'];
        $contact_number = $_POST['contact_number'];
        $p_name = $_POST['product_name'];
        $p_price = $_POST['product_price'];
        $body = $_POST['body'];
        $file = $_FILES['Timage'];
        
        if (!move_uploaded_file($file['tmp_name'], __DIR__ . '/../uploads/' . $file['name'])) 
        {
            
            $TimgFlag=0;
        }
        else
        {
            $TimgFlag=1;
        }
    }

    $queryDomain = "SELECT * FROM `domains` WHERE `id` = '{$d_id}'";
    $resultDomain = mysqli_query($con, $queryDomain);
    if (!$resultDomain) {
        die("Query Failed" . mysqli_error($con));
    } else {
        $data = mysqli_fetch_assoc($resultDomain);
    }


    $_SESSION['table'] = $table;
    $_SESSION['template'] = $data['template'];
    
    $_SESSION['~SUBJECT~'] = $subject;
    $_SESSION['~PCN~'] = $contact_number;
    $_SESSION['~PRODUCT_NAME~'] = $p_name;
    $_SESSION['~PRODUCT_PRICE~'] = $p_price;
     $_SESSION['~BODY~'] = $body;
    if($TimgFlag == 1)
    {
        $_SESSION['~IMG~'] = str_replace("includes/shoot_final.php", "uploads/Timage.PNG", $data['d_url']);
    }
    else
    {
        $_SESSION['~IMG~'] ="";
    }
    $_SESSION['domain'] = $data['id'];
    $_SESSION['domain_url'] = $data['d_url'];
    $_SESSION['domain_name'] = $data['d_name'];
    $_SESSION['domain_email'] = $data['d_email'];
    $_SESSION['domain_pwd'] = $data['d_pwd'];
}




//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../php_mail/vendor/autoload.php';

if (isset($_GET['ans'])) {
    $ans = $_GET['ans'];
}

if ($ans == 'true') {

    
   
    // ------------------------------------------------

    $query_template = "select * from `templates` where `t_sname` = '{$_SESSION['template']}'";
    $result_template = mysqli_query($con, $query_template);
    if (!$result_template) {
        die("Query Failed 1" . mysqli_error($con));
    } else {
        $row_template = mysqli_fetch_assoc($result_template);
        $mailName = $row_template['t_fname'];
        $mail_message =  $row_template['t_content'];
        $placeholders = $row_template['placeholders'];
        $placeholders_arr = explode('|',$placeholders);
        
    }

?>

    <!-- ////////////////////////////////////////////////////////////// -->

    <?php

    $query_table = "select * from `{$_SESSION['table']}` where flag = 0 order by `id` asc limit 1";
    $result_table = mysqli_query($con, $query_table);
    if (!$result_table) {
        die("Query Failed 2 " . mysqli_error($con));
    } else {

        $count = mysqli_num_rows($result_table);

        while ($row_table = mysqli_fetch_assoc($result_table)) {

            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            $id = $row_table['id'];

            $queryFlag1 = "update `{$_SESSION['table']}` set `flag` = 1 where `id` = '$id'";

            $resultFlag1 = mysqli_query($con, $queryFlag1);

            if (!$resultFlag1) {
                die("Update Failed For " . $row_table['id'] . ": " . $row_table['email'] . mysqli_error($con));
            } else {

                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = $_SESSION['domain_email'];                     //SMTP username
                    $mail->Password   = $_SESSION['domain_pwd'];                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->Sender     = $_SESSION['domain_email'];

                    //Recipients
                    $mail->setFrom($_SESSION['domain_email'], $mailName);
                    $mail->addAddress($row_table['email'], $row_table['name']);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    $mail->addReplyTo($_SESSION['domain_email'], 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = $_SESSION['~SUBJECT~'];
                    $message_body = str_replace("~NAME~", ucfirst($row_table['name']), $mail_message);
                    $message_body = str_replace("~UNSUBSCRIBE~", $row_table['email'], $message_body);
                    $message_body = str_replace("~EMAIL~", $row_table['email'], $message_body);
                    $message_body = str_replace("~USER_ID~", 'admin', $message_body);
                    $message_body = str_replace("~DATE~", date("Y-m-d"), $message_body);
                    $arr_d=explode('/',$_SESSION['domain_url']);
                    $message_body = str_replace("~DOMAIN~", $arr_d[2], $message_body);
                    
                    
                    
                    foreach($placeholders_arr as $placeholder)
                    {
                   
                        $message_body= str_replace($placeholder,$_SESSION[$placeholder], $message_body);            
                        
                    }
                    
                    
                    $mail->Body    = $message_body;
                    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


                    echo "<div style='display:none'>";
                    $mail->send();
                    echo "</div>";
                 
                    $queryFlag2 = "update `{$_SESSION['table']}` set `flag` = 2 where `id` = '$id'";

                    $resultFlag2 = mysqli_query($con, $queryFlag2);
                    
                    $revamp_qry= "insert into revamp_reports values( '".$row_table['email']."',".$_SESSION['domain'].",now(),0,NULL,'admin') ";
                    //$revamp_qry= "insert into revamp_reports values($row_table['email'],$_SESSION['domain'],now(),0,NULL,admin) ";
                    $revamp_flag=mysqli_query($con,$revamp_qry);
                    
                    if (!$resultFlag2) {
                        die("Query Failed 3 " . mysqli_error($con));
                    } else {
                        ?>

                        <h1 style='text-align:center; background-color:#333; color:#fff; padding: 16px'>
                            REAL TIME MAILING REPORT 1.0
                        </h1>

                        <h2 style='text-align:center; color: red'>
                            Message Has Been Sent Successfully To: <?php echo $row_table['name']; ?>
                            <br>
                            
                            <small>
                                Email: <?php echo $row_table['email']; ?>
                            </small>
                        </h2>

                        <!-- echo "<h1 style='text-align:center; background-color:#333; color:#fff; padding: 16px'>";
                        echo "REAL TIME MAILING REPORT";
                        echo "Message Has Been Sent Successfully To: ".$row_table['name']. "<br>"."Email: ".$row_table['email'];
                        echo "</h1>"; -->

                        <!-- echo "<h3 style='text-align:center; color:#fff;'>";
                        echo "Message Has Been Sent Successfully To: ".$row_table['name']. "<br>"."Email: ".$row_table['email'];
                        echo "</h3>"; -->
   
                <div class="container">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Status
                                    </th>
                                    <th>
                                        Count
                                    </th>
                                </tr>

                            </thead>
                            <tbody>
                                <?php

                                $queryGroup = "SELECT count(*) as count, flag FROM `{$_SESSION['table']}` group by flag";

                                $resultGroup = mysqli_query($con, $queryGroup);

                                if (!$resultGroup) {
                                    die("Query Failed 4 " . mysqli_error($con));
                                } else {
                                    while ($row_group = mysqli_fetch_assoc($resultGroup)) {
                                        $count = $row_group['count'];
                                        $flag = $row_group['flag'];
                                ?>
                                        <tr>
                                            <td><?php

                                            if($flag == 0){
                                                echo "Not Sent";
                                            }
                                            elseif($flag == 1){
                                                echo "Invalid ID";
                                            }
                                            elseif($flag == 2){
                                                echo "Sent";
                                            }
                                            elseif($flag == 3){
                                                echo "Bounce";
                                            }
                                            elseif($flag == 4){
                                                echo "Unsubcribed";
                                            }
                                            
                                            // echo $flag; 
                                            
                                            
                                            ?></td>
                                            <td> <?php echo $count; ?></td>
                                            
                                        </tr>
                                <?php
                                    }
                                }


                                ?>
                            </tbody>
                        </table>
                </div>
        <?php
                    }
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            }
        }

        if ($count == 0) {
            $ans = false;
            
            include('sent_report.php');
        }
    }
} else {
    
   ?>

<h1 style='text-align:center; background-color:#333; color:#fff; padding: 16px'>
REAL TIME MAILING REPORT 1.0
</h1>

    <div class="container">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>
                        Status
                    </th>
                    <th>
                        Count
                    </th>
                </tr>

            </thead>
            <tbody>
                <?php

                $queryGroup = "SELECT count(*) as count, flag FROM `{$_SESSION['table']}` group by flag";

                $resultGroup = mysqli_query($con, $queryGroup);

                if (!$resultGroup) {
                    die("Query Failed 4 " . mysqli_error($con));
                } else {
                    while ($row_group = mysqli_fetch_assoc($resultGroup)) {
                        $count = $row_group['count'];
                        $flag = $row_group['flag'];
                ?>
                        <tr>
                            <td><?php

                            if($flag == 0){
                                echo "Not Sent";
                            }
                            elseif($flag == 1){
                                echo "Invalid ID";
                            }
                            elseif($flag == 2){
                                echo "Sent";
                            }
                            elseif($flag == 3){
                                echo "Bounce";
                            }
                            elseif($flag == 4){
                                echo "Unsubcribed";
                            }
                            
                            // echo $flag; 
                            
                            
                            ?></td>
                            <td> <?php echo $count; ?></td>
                            
                        </tr>
                <?php
                    }
                }


                ?>
            </tbody>
        </table>
    </div>
   <?php
   
 
   session_destroy();
}

?>


<?php if ($ans != 'false') : ?>


    <script>
        setTimeout(function() {
            location.replace("<?php echo $_SESSION['domain_url']; ?>?ans=<?php if ($ans == 'true') { echo 'true';} else {echo 'false';} ?>");
        }, 3000);
    </script>

<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
