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
                                                    Order Cancelled</td>
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
                                                    <b> Order: </b>{{ $data['cart_id'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    <b> Order Date: </b>{{ $data['order_date'] }} 
                                                </td>
                                            </tr>
                                            {{-- <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    <b> Payment Method: </b> -
                                                </td>
                                            </tr> --}}
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    <b> <u> Order Status: </b> {{ $data['status'] }} </u>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Your order has been cancelled as per your request.
                                                </td>
                                            </tr>
                                             <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    You will receive a credit note which you will be able to redeem at any of our stores within 6 months. No cash refunds are permitted.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    <br> Any questions? <br> 
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    You can reach us at:<br> <a
                                                        href="mailto:order@maisondesfleurs.com"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">order@maisondesfleurs.com</a>
                                                    or <a href="tel:971552236866"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">+971
                                                        55 223 6866</a>
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