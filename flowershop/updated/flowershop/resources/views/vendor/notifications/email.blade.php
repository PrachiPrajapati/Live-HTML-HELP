<!DOCTYPE html>
<html>

<head>
    <title> Flower shop </title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400&display=swap" rel="stylesheet">
</head>

<body style="padding: 0px; margin: 0px;" bgcolor="#fff">
    <table width="100%" cellspacing="0" cellpadding="0">
        <tbody>
            <tr>
                <td>
                    <table class="wrapper" width="600" bgcolor="#ffffff" align="center">
                        <tbody>
                            <tr>
                                <td style="padding: 80px 50px; text-align: center;">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <a href="" target="_blank"> <img src="{{ asset('frontend/email-images/logo.svg') }}"
                                                            alt="logo-image"></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="30"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-family: 'Roboto', sans-serif; font-size: 36px; line-height: 40px; font-weight: 300;">
                                                    Forgot Password</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Hello
                                                    @foreach ($introLines as $line)
                                                    {{ $line }}

                                                    @endforeach
                                                    <br><br>
                                                    <a href="{{ $actionUrl }}" target="_blank"
                                                        style="padding: 10px 25px; display: inline-block; text-decoration: none; background: black; font-family: 'Roboto', sans-serif; font-size: 14px; line-height: 25px; text-align: center; font-weight: 300; color: #fff;">
                                                    Reset Password    
                                                    </a>
                                                    <br>
                                                </td>
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                    Having trouble?<br>If you are still having trouble resetting your password or have
                                    further questions, please feel free to email us on <a
                                        href="mailto:mail@maisondesfleurs.com" target="_blank"
                                        style="color: black; font-weight: bold; text-decoration: underline;">mail@maisondesfleurs.com</a> and
                                    someone from our team will be in touch with you soon! </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                            <tr>
                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                    Thank You,<br>Maison Des Fleurs Team</td>
                            </tr>
                            <tr>
                                <td height="50"></td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ asset('frontend/email-images/flower-image.png') }}" alt="flower-image">
                                </td>
                            </tr>
                            <tr>
                                <td height="20"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    </td>
    </tr>
    </tbody>
    </table>
</body>

</html>