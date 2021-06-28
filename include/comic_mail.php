<?php
    //Include the DB Connection File & Mail Config 
    include './db_connection.php';
    include './mail_config.php';
    
    //Host Name & Location
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $address = "https://";   
    else  
        $address = "http://";
    $address .= $_SERVER['SERVER_NAME'];

    function random_comic_url(){
            $random_comic = rand(0,2478);
            $json = file_get_contents("https://xkcd.com/$random_comic/info.0.json");
            $data = json_decode($json);

            //Store Value in Array
            $comic_data = array("URL"=> $data->img, "title"=> $data->title, "alt_text"=> $data->alt, "num"=>$data->num, "attachment_name"=> parse_url($data->img, PHP_URL_PATH));
            return $comic_data; 
    }

    $comic_data = random_comic_url();
    $comic_num = $comic_data['num'];
    $comic_image_URL = $comic_data['URL'];
    $comic_alt_text = $comic_data['alt_text'];
    $comic_data_title = $comic_data['title'];

    //Insert Query & Check if Username & Password is correct or not.
    $select_sql = "SELECT email,verification_key,random_id FROM accounts WHERE verified = 1 AND subscribed = 1";
    $result_of_select = mysqli_query($db_connection, $select_sql);

    while ($row = mysqli_fetch_assoc($result_of_select)) {
        echo "\t\n <br> Sending Email Now : ";
        $resend_secure_email = md5($row['email']);
        $resend_secure_vkey = md5($row['verification_key']);
        $resend_random_id = $row['random_id'];
        $to = $row['email'];
        
        //Create Mail
        $mail->ClearAllRecipients();
        $mail->addAddress($to);
        $mail->addStringAttachment(file_get_contents($comic_image_URL), $comic_data['attachment_name']);
        $mail->isHTML(true);
        $mail->Subject= "Comic : " . $comic_data["title"];
        $mail_body = <<<EOD
        <!DOCTYPE html>
        <html>
        <head>
        </head>
        <body>
        <div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <p><strong>Number</strong>: $comic_num </p>
                <p><strong>Comic Title</strong>: $comic_data_title </p>
                <p><strong>Link</strong>: $comic_image_URL </p>
                <img border='1' src=$comic_image_URL alt=$comic_alt_text>
                 <p> If you would prefer not to receive these emails please click <a href='$address/include/unsubscribe.php?rid=$resend_random_id&eid=$resend_secure_email&vid=$resend_secure_vkey' target="_blank"><i>unsubscribe</i> </a>
                 </p>
            </tbody></table>
        </div>
        </body>
        </html>
        EOD;
        $mail->Body=$mail_body;
        if(!$mail->send()){
            echo $row['email']. " : Mail Can't Send";
        }
        else{
            echo $row['email']. " : Mail Sent";
        }
    }
?>