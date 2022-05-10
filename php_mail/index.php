<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once "vendor/autoload.php";

if(isset($_GET['ans'])){
    $ans = $_GET['ans'];
}

if($ans == 'true'){
    
$con = mysqli_connect('localhost', 'u219401996_test_uname', 'Testisbest@1', 'u219401996_test_db');
if(!$con){
    die("Connection Failed");
}

$query = "select * from `test` where `flag` = 0 limit 5";
$result = mysqli_query($con, $query);

    if(!$result){
        die("Query Failed");
    }
    else{
        $count = mysqli_num_rows($result);
       
        while($row=mysqli_fetch_assoc($result)){
            
           
            
                
                if(file_exists('certificates/'.$row["phone"].'.pdf')){
                    //PHPMailer Object
                $mail = new PHPMailer(true); //Argument true in constructor enables exceptions
                
                //From email address and name
                $mail->From = "contact@webwidesolutions.in";
                $mail->FromName = "Webwide Solutions";
                
                //To address and name
                // $mail->addAddress("recepient1@example.com", "Recepient Name");
                $mail->addAddress($row['email']); //Recipient name is optional
                
                //Address to which recipient will reply
                $mail->addReplyTo("contact@webwidesolutions.in", "Reply");
                
                //CC and BCC
                $mail->addCC("anirban@webwidesolutions.in");
                // $mail->addBCC("bcc@example.com");
                
                //Send HTML or Plain Text email
                $mail->isHTML(true);
                
                $mail->Subject = "Download Your E-Cetificate | New Career Path, New Opportunities";
                $mail->Body = '
                <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p style="padding-right: 0px;padding-left: 0px;" align="center">
        <a href="https://www.webwidesolutions.in/" target="_blank">
            <img align="center" border="0" src="https://www.webwidesolutions.in/testing/meramail/images/image-1.png" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 13%;max-width: 68.9px;"
                width="68.9" class="v-src-width v-src-max-width">
        </a>
    </p>


    <hr>
    <br>

    <h1 style="
        margin: 0px;
        color: #5d49d6;
        line-height: 130%;
        text-align: center;
        word-wrap: break-word;
        font-weight: normal;
        font-family: comic sans ms,sans-serif;
        font-size: 35px;
    ">Download Your E-Certificate For Attending Our Webinar.</h1>
    <div align="center">
        <img align="center" border="0" src="https://www.webwidesolutions.in/testing/meramail/images/image-3.jpeg" alt="Phone Authentication" title="Phone Authentication" style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 490px;"
            width="490" class="v-src-width v-src-max-width">
    </div>
    <p style="    overflow-wrap: break-word;
    word-break: break-word;
    padding: 10px;
    font-family: arial,helvetica,sans-serif;text-align: center;">
        <strong>
        Join the Bootcamp today, to jump-start your coding career.
    </strong>
    </p>
    <div align="center">
        <a href="https://www.webwidesolutions.in/online-web-development-bootcamp-registration" target="_blank" style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #5d49d6; background-color: #ffffff; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word;border-top-width: 1px; border-top-style: solid; border-top-color: #5d49d6; border-left-width: 1px; border-left-style: solid; border-left-color: #5d49d6; border-right-width: 1px; border-right-style: solid; border-right-color: #5d49d6; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #5d49d6;">
            <span style="display:block;padding:10px 50px;line-height:100%;"><strong><span style="font-size: 14px; line-height: 14px;">Register For Free&nbsp; &gt;&gt;</span></strong>
            </span>
        </a>
    </div>
    <br>
    <div align="center">
        <a href="https://www.webwidesolutions.in/" target="_blank" style="box-sizing: border-box;display: inline-block;font-family:arial,helvetica,sans-serif;text-decoration: none;-webkit-text-size-adjust: none;text-align: center;color: #ffffff; background-color: #5d49d6; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; width:auto; max-width:100%; overflow-wrap: break-word; word-break: break-word; word-wrap:break-word; border-top-color: #5d49d6; border-top-style: solid; border-top-width: 2px; border-left-color: #5d49d6; border-left-style: solid; border-left-width: 2px; border-right-color: #5d49d6; border-right-style: solid; border-right-width: 2px; border-bottom-color: #5d49d6; border-bottom-style: solid; border-bottom-width: 2px;">
            <span style="display:block;padding:10px;line-height:120%;"><span style="font-size: 14px; line-height: 16.8px;">Learn </span><strong><span style="font-size: 14px; line-height: 16.8px;">More</span></strong></span>
        </a>
    </div>
    <br>

    <p style="font-size: 14px; line-height: 140%;text-align: center;"><span style="font-size: 18px; line-height: 25.2px; font-family: Montserrat, sans-serif;">www.webwidesolutions.in</span></p>

    <div style="color: #888888; line-height: 180%; text-align: center; word-wrap: break-word;">
        <p style="font-size: 14px; line-height: 180%;"><span style="font-family: Montserrat, sans-serif; font-size: 14px; line-height: 25.2px;">Our Bootcamps are designed to take you from little or no coding experience to job-ready in 3 months. This means lots of effective practice and tons of help from the developers running the bootcamp.</span></p>
        <p style="font-size: 14px; line-height: 180%;">&nbsp;</p>
        <p style="font-size: 14px; line-height: 180%;"><span style="font-family: Montserrat, sans-serif; font-size: 12px; line-height: 21.6px;">© 2021 Webwide Solutions. All Rights Reserved.</span></p>
    </div>
</body>

</html>
                            ';
                $mail->AltBody = "Download Your E-Certificate
                                    For Attending Our Webinar.";
                
                
               
                
                 $file_to_attach = 'certificates/'.$row["phone"].'.pdf';
                
                 $mail->AddAttachment( $file_to_attach , $row["phone"].'.pdf' );
                
                try {
                        $conn = mysqli_connect('localhost', 'u219401996_test_uname', 'Testisbest@1', 'u219401996_test_db');
                        if(!$conn){
                            die("Connection Failed");
                        }
                        
                        $id = $row['id'];
                        $queryFlag = "update `test` set `flag` = 1 where `id` = '$id'";
                        
                        $resultFlag = mysqli_query($conn,$queryFlag);
                        
                        if(!$resultFlag){
                            die("Update Failed For ".$row['name'].mysqli_error($conn));
                        }
                        else{
                            $mail->send();
                            echo "Message has been sent successfully to ".$row['name']."<br>";
                        }
                   
                }
                catch (Exception $e) {
                    echo "Message was not sent to ".$row['name'] . $mail->ErrorInfo."<br>";
                }
                finally
                {
                    unset($mail);
                }
            }
            else{
                    $connn = mysqli_connect('localhost', 'u219401996_test_uname', 'Testisbest@1', 'u219401996_test_db');
                    if(!$connn){
                        die("Connection Failed");
                    }
                    
                    $id = $row['id'];
                    $queryFlag = "update `test` set `flag` = 2 where `id` = '$id'";
                    
                    $resultFlag = mysqli_query($connn,$queryFlag);
                    
                    if(!$resultFlag){
                        die("Update Failed For ".$row['name'].mysqli_error($connn));
                    }
                    else{
                        echo "File not found for ".$row['name']."<br>";
                    }
            }
        }
        
        if($count == 0){
            $ans = false;
        }
    }
}

else{
    echo "All mail sent at " ;
    $t=time();
    echo($t . "<br>");
}

?>

<?php if($ans != 'false'): ?>

<script>

setTimeout(function() {
  location.replace("https://www.webwidesolutions.in/testing/automatic_mail/index.php?ans=<?php if($ans == 'true'){ echo 'true';}else{echo 'false';} ?>")
}, 10000);

</script>

<?php endif; ?>

