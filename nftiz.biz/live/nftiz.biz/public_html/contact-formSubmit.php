<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'https://www.nftiz.biz/') !== 0) {
    // it's SPAM
    exit;
}

if (preg_match( "/bcc:|cc:|multipart|\[url|Content-Type:/i", implode($_POST))) {
    // it's SPAM
    exit;
}

if ( isset($_POST['captcha']) && ($_POST['captcha'] != "") ){
    // Validation: Checking entered captcha code with the generated captcha code
    if(strcasecmp($_SESSION['captcha'], $_POST['captcha']) != 0){
        // Note: the captcha code is compared case insensitively.
        // if you want case sensitive match, check above with strcmp()
        header('Location: https://www.nftiz.biz/?status=error_captcha#contact');
        exit;
    }else{
        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $name = $_POST['name'];
        $email = $_POST['email'];
        $skype = $_POST['skype_id'];
        $phone = $_POST['phone_no'];
        $pricing = $_POST['pricing'];
        $message = $_POST['message'];

        //check if the honeypot field is filled out. If not, then continue.
        if (!empty($_POST['website'])) {
            // this is bot submission
            header('Location: https://www.nftiz.biz/?status=error#contact');   
            exit;
        }

        $allowed_origins = array('https://www.nftiz.biz');
        if (isset($_SERVER['HTTP_ORIGIN']) && !in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
            // it's SPAM
            exit;
        }

        if($name == '' || $email == '' || $phone == ''){
            header('Location: https://www.nftiz.biz/?status=error#contact');
            exit;   
        }
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();                                       //Send using SMTP
            $mail->SMTPAuth   = true;                             //Enable SMTP authentication
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Host       = 'smtp.gmail.com';                  //Set the SMTP server to send through
            $mail->Port       = 587;                               //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            $mail->Username   = 'noreply@nftiz.biz';           //SMTP username
            $mail->Password   = 'yudiz@321';                       //SMTP password
            $mail->From       = 'noreply@nftiz.biz';
            $mail->AddAddress('contact@nftiz.biz', 'nftiz.biz');     //Add a recipient // contact@nftiz.biz
            $mail->AddAddress('chirag@yudiz.com', 'Chirag Leuva');
            $mail->AddAddress('dhruv@yudiz.com', 'Dhruv Samani');
            $mail->AddAddress('nirav@yudiz.com', 'Nirav Chauhan');
            $mail->AddAddress('vishal@yudiz.com', 'Vishal Kachalia');
            // $mail->AddAddress('wordpressprojects1947@gmail.com', 'Developer');
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Request a Demo From NFTIZ';
            $mail->Body    = '<b>Name: </b>'.$name.'<br>'.
                            '<b>Email: </b>'.$email.'<br>'.
                            '<b>Skype ID: </b>'.$skype.'<br>'.
                            '<b>Phone No: </b>'.$phone.'<br>'.
                            '<b>Message: </b>'.$message;//'<b>Pricing: </b>'.$pricing.'<br>'.
            $mail->send();
            header('Location: https://www.nftiz.biz/thankyou');
        } catch (Exception $e) {
            header('Location: https://www.nftiz.biz/?status=error#contact');
            exit;
        }
    }
}else{
    header('Location: https://www.nftiz.biz/?status=error#contact');
    exit;
}
?>