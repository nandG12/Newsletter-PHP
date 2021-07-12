<?php
$idpass_error=false;
if(defined('STDIN')){ //For Command Line
    if(isset($argv[1]) && isset($argv[2])){
        $id = $argv[1];
        $password = $argv[2];

        //You need to manually Change this Host Name & Location If you running the Script From Command Line
        $address = 'https://xyz.xyz';
    }
    else{
        $idpass_error=true;
        echo 'Enter id and password then try again.';
    }
} 
else{ //For Web browser
    $id = isset($_GET['id']) ? $_GET['id'] : NULL;
    $password = isset($_GET['pwd']) ? $_GET['pwd'] : NULL;

    //Host Name & Location
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'){
        $address = "https://";   
    }
    else{  
        $address = "http://";
    }
    $address .= isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : NULL;

}
if(isset($id) && isset($password))
{
    /* 
    This is the Password Protected Script Without the correct credentials User can't able to access this script.
    for running from the Command Line : php comic_mail.php {id here} {password here}
    for executing through web browser https://{URL}/comic_mail.php?id={id here}&password={password here}
    */
    if($id=='test' && $password=='password'){ //This is just an example of ID & Password. Change it.
    
        //Include the DB Connection File & Mail Config 
        include __DIR__.'/db_connection.php';
        include __DIR__.'/mail_config.php';
        
        function random_comic_url(){
                $url ='https://c.xkcd.com/random/comic/';
                $random_comic = rtrim(explode('.com/',get_headers($url)[07])[01], '/');
                $json = file_get_contents("https://xkcd.com/$random_comic/info.0.json");
                $data = json_decode($json);

                //Publish Date
                $day = $data->day;
                $mon = $data->month;
                $year = $data->year;
                $release_date_ts=strtotime("$year-$mon-$day");
                $release_date=date('Y-m-d',$release_date_ts);
                $date=date_create($release_date);
                $rel_date=date_format($date,'l, F jS, Y');

                //Store Value in Array
                $comic_data = array('URL'=> $data->img, 'title'=> $data->title, 'rel_date'=>$rel_date ,'alt_text'=> $data->alt, 'num'=>$data->num, 'attachment_name'=> parse_url($data->img, PHP_URL_PATH));
                return $comic_data; 
        }

        $comic_data = random_comic_url();
        $comic_num = $comic_data['num'];
        $comic_image_URL = $comic_data['URL'];
        $comic_alt_text = $comic_data['alt_text'];
        $comic_data_title = $comic_data['title'];
        $comic_rel_date = $comic_data['rel_date'];

        //Insert Query & Check if Username & Password is correct or not.
        $select_sql = "SELECT email,verification_key,random_id FROM accounts WHERE verified = 1 AND subscribed = 1";
        $result_of_select = mysqli_query($db_connection, $select_sql);

        while ($row = mysqli_fetch_assoc($result_of_select)) {
            try {
                echo "\t\n Sending Email Now : ";
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
                    <table align="center" width="100%" border="0" cellspacing="0" cellpadding="0">
                        <p><strong>Comic Title</strong>: $comic_data_title </p>
                        <p><strong>Number</strong>: $comic_num </p>
                        <p><strong>Publish Date</strong>: $comic_rel_date </p>
                        <img border='1' src=$comic_image_URL alt=$comic_alt_text>
                         <p> If you would prefer not to receive these emails please click <a href='$address/include/unsubscribe.php?rid=$resend_random_id&eid=$resend_secure_email&vid=$resend_secure_vkey' target="_blank"><i>unsubscribe</i> </a>
                         </p>
                    </tbody></table>
                </div>
                </body>
                </html>
                EOD;
                $mail->Body=$mail_body;
                if($mail->send()){
                    echo $row['email'] . " : Mail Sent";
                }
            } 
            catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    //
    }
    else{
        echo 'Access Denied';
    }
}
else{
    if(!$idpass_error){
        echo 'Access Denied';
    }
}
?>