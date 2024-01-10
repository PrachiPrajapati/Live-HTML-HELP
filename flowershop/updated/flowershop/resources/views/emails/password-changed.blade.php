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
                                                <td height="40"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="font-family: 'Roboto', sans-serif; font-size: 36px; line-height: 40px; font-weight: 300;">
                                                    Password Changed</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Hello {{ $data['username'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Your password for the Maison Des Fleurs account with the username {{ $data['username'] }}
                                                    has been successfully changed!</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    You can now log into your account with your new password at <a
                                                        href="https://www.maisondesfleurs.com" target="_blank"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">www.maisondesfleurs.com</a> to proceed with your shopping!</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
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