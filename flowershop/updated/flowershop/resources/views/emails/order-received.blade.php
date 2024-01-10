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
                                                    Order Received</td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Hello {{ $data['username'] }},<br>Thank you for placing an order with Maison des Fleurs.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    <b>Your Order: {{ $data['cart_id'] }}</b><br>Placed on {{ $data['order_date'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px; text-align: left;">
                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tr style="vertical-align: top;">
                                                            <td style="padding: 30px 15px; border: 1px solid #F9F7F5">
                                                                <b>Billing Info:</b>
                                                                <br>
                                                                @if(Auth::check())
                                                                    {{ $data['billing_details'] }}
                                                                @else
                                                                    {{ $data['username'] }}
                                                                    {{ $data['billing_details'] }}
                                                                    {{ $data['city'] }}
                                                                    {{ $data['pincode'] }}
                                                                    {{ $data['country'] }}
                                                                @endif
                                                                <br>
                                                                T: <a href="tel:0581544505" style="color: black; text-decoration: underline;">0581544505</a>
                                                            </td>
                                                            <td style="padding:30px 15px;  border: 1px solid #F9F7F5" >
                                                                <b>Delivery Info:</b>
                                                                <br>
                                                                @if(Auth::check())
                                                                    {{ $data['username'] }}
                                                                    {{ $data['delivery_details'] }}
                                                                    {{ $data['delivery_city'] }}
                                                                    {{ $data['delivery_pincode'] }}
                                                                    {{ $data['delivery_country'] }}
                                                                    {{ $data['delivery_contact'] }}
                                                                @else
                                                                    {{ $data['username'] }}
                                                                    {{ $data['billing_details'] }}
                                                                    {{ $data['city'] }}
                                                                    {{ $data['pincode'] }}
                                                                    {{ $data['country'] }}
                                                                @endif
                                                                <br>
                                                                T: <a href="tel:0527616214" style="color: black; text-decoration: underline;">0527616214</a>
                                                            </td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="padding: 30px 15px; border: 1px solid #F9F7F5">
                                                                <b>Payment Method</b><br>
                                                                Telr Payments
                                                            </td>
                                                            <td style="padding:30px 15px;  border: 1px solid #F9F7F5">
                                                                <b>Delivery Method</b><br>
                                                                Delivery Charges - {{ $data['delivery_charge'] }}
                                                            </td>
                                                        </tr>
                                                        <tr style="vertical-align: top;">
                                                            <td style="padding: 30px 15px; border: 1px solid #F9F7F5">
                                                                <b>Delivery Date and Time</b><br>
                                                                {{ $data['delivery_date'] }} - {{ $data['delivery_time'] }}
                                                            </td>
                                                            <td style="padding:30px 15px;  border: 1px solid #F9F7F5">
                                                                <b>Delivery Comments</b> <br>
                                                                {{ $data['comment'] }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    You can check the status of your order by <a href="{{ route('home') }}" target="_blank"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">logging
                                                        into your account</a>.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px; color: black;">
                                                    Any questions? <br> You can reach us at:<br> <a
                                                        href="mailto:order@maisondesfleurs.com"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">order@maisondesfleurs.com</a>
                                                    or <a href="tel:971552236866"
                                                        style="color: black; font-weight: bold; text-decoration: underline;">+971
                                                        55 223 6866</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="20"></td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style=" font-family: 'Roboto', sans-serif; font-size: 16px; line-height: 30px;">
                                                    Thank You,<br>Maison Des Fleurs</td>
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