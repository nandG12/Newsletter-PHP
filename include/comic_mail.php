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

                //Save File
                if(file_put_contents( basename($data->img),file_get_contents($data->img))) {
                    echo 'File downloaded successfully';
                }
                else {
                    echo 'File downloading failed.';
                }

                //Store Value in Array
                $comic_data = array('URL'=> $data->img, 'title'=> $data->title, 'rel_date'=>$rel_date ,'alt_text'=> $data->alt, 'num'=>$data->num, 'file_name'=> basename($data->img),'attachment_name'=> parse_url($data->img, PHP_URL_PATH));
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

                //Create Mail With Inbuilt Mail Function
                $subject = "Comic : " . $comic_data["title"];;
                $file = $comic_data['file_name']; 
                
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
                // Header for sender info 
                $headers = "From: $fromName"." <".$from.">"; 
                // Boundary  
                $semi_rand = md5(time());  
                $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
                // Headers for attachment  
                $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
                // Multipart boundary
                $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" . 
                "Content-Transfer-Encoding: 7bit\n\n" . $mail_body . "\n\n";
                // Preparing attachment 
                if(!empty($file) > 0){ 
                    if(is_file($file)){ 
                        $message .= "--{$mime_boundary}\n"; 
                        $fp =    @fopen($file,"rb"); 
                        $data =  @fread($fp,filesize($file)); 
                 
                        @fclose($fp); 
                        $data = chunk_split(base64_encode($data)); 
                        $message .= "Content-Type: application/octet-stream; name=\"".basename($file)."\"\n" .  
                        "Content-Description: ".basename($file)."\n" . 
                        "Content-Disposition: attachment;\n" . " filename=\"".basename($file)."\"; size=".filesize($file).";\n" .  
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n"; 
                    } 
                } 
                $message .= "--{$mime_boundary}--"; 
                $returnpath = "-f" . $from;

                // Send email 
                $mail = @mail($to, $subject, $message, $headers, $returnpath);  
                 
                // Email sending status 
                echo $mail?"<h1>Email Sent Successfully!</h1>":"<h1>Email sending failed.</h1>";

                // Delete the File
                $status=unlink($comic_data['file_name']);    
                if($status){  
                    echo 'File deleted successfully';    
                }else{  
                    echo 'Error while deleting the file';    
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