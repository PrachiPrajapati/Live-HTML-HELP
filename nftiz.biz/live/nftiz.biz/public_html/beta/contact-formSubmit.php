<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// if (isset($_POST['g-recaptcha-response'])) {
//     $captcha = $_POST['g-recaptcha-response'];
// } else {
//     $captcha = false;
// }
// if (!$captcha) {
//     header('Location: https://www.nftiz.biz/?status=error#contact');   
// }else{
    // $secret   = 'Your secret key here';
    // $response = file_get_contents(
    //     "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']
    // );
    // // use json_decode to extract json response
    // $response = json_decode($response);

    // if ($response->success === false) {
    //     header('Location: https://www.nftiz.biz/?status=error#contact');   
    // }else{
session_start();

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'https://www.nftiz.biz/beta/') !== 0) {
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
        header('Location: https://www.nftiz.biz/beta/?status=error_captcha#contact');
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
        if (!empty($_POST['hidden_field'])) {
            // this is bot submission
            header('Location: https://www.nftiz.biz/beta/?status=error#contact');   
            exit;
        }

        $allowed_origins = array('https://www.nftiz.biz');
        if (isset($_SERVER['HTTP_ORIGIN']) && !in_array($_SERVER['HTTP_ORIGIN'], $allowed_origins)) {
            // it's SPAM
            exit;
        }

        if($name == '' || $email == '' || $phone == ''){
            header('Location: https://www.nftiz.biz/beta/?status=error#contact');   
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
            // $mail->AddAddress('contact@nftiz.biz', 'nftiz.biz');     //Add a recipient // contact@nftiz.biz
            // $mail->AddAddress('chirag@yudiz.com', 'Chirag Leuva');
            // $mail->AddAddress('kalyan@yudiz.com', 'Kalyan Acharya');
            $mail->AddAddress('wordpressprojects1947@gmail.com', 'Developer');
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Request a Demo From NFTIZ';
            $mail->Body    = '<b>Name: </b>'.$name.'<br>'.
                            '<b>Email: </b>'.$email.'<br>'.
                            '<b>Skype ID: </b>'.$skype.'<br>'.
                            '<b>Phone No: </b>'.$phone.'<br>'.
                            '<b>Message: </b>'.$message;//'<b>Pricing: </b>'.$pricing.'<br>'.
            $mail->send();
            header('Location: https://www.nftiz.biz/beta/thankyou.html');
            exit;
        } catch (Exception $e) {
            header('Location: https://www.nftiz.biz/beta/?status=error#contact');
            exit;
        }
    }
}else{
    header('Location: https://www.nftiz.biz/beta/?status=error#contact');
    exit;
}
//     }    
// }
?>