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
                                                    <a href="" target="_blank"> <img src="{{ asset('frontend/email-images/logo.svg') }}" alt="logo-image"></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="40"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-family: 'Roboto', sans-serif; font-size: 36px; line-height: 40px; font-weight: 300;">
                                                    Payment Failure</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Hello {{ $data['username'] }},
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    We’re sorry, your payment transaction has failed and could not be processed at this time.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Please see the transaction details below for your reference.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Please double check that your credit card information is correct and try again. 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    If you are still facing issues, you can reach us by email at: <a href="https://order@maisondesfleurs.com">order@maisondesfleurs.com </a> or by phone/ WhatsApp at <a href="tel:971552236866" style="color: black; font-weight: bold; text-decoration: underline;">+971 55 223 6866</a> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Thank you,
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Maison Des Fleurs 
                                                </td>
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