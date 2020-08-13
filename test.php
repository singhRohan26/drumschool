<?php
    $email = $_GET['email'];
    $to = $email;
    $message =  '<div class="header">
                    <div class="side_padding">
                        <a class="navbar-brand" href="#"><img src="https://negotium.one/img/logo.png" alt="logo" style="height: 50px;width: 222px;"></a>
                    </div>
                </div>
                <strong>We have received your request to be notified, when we launch our new website. In the meantime, please like and follow our social media pages.</strong>
                <div class="social_link boxs" style="margin-top: 10px;">
                    <a href="https://facebook.com/Negotium.One/" target="_blank"><img src="https://negotium.one/img/facebook.png" style="height:30px;margin-right: 15px;"></a>
                    <a href="https://instagram.com/negotium.one" target="_blank"><img src="https://negotium.one/img/insta.png" style="height:30px;margin-right: 14px;"></a>
                    <a href="https://linkedin.com/company/negotium-one" target="_blank"><img src="https://negotium.one/img/linkedin.png" style="height:30px;"></a>
                </div>
                <p>Thanks for being awesome!</p>
                <strong>Contact Number: 0800 246 1948 </strong><br>
                <strong>E-mail: hello@negotium.one </strong>';
    
    function send($to, $message){
        
        $url = 'https://api.sendgrid.com/';
        $user = 'NegotiumUK';
        $pass = 'Negotium2020';
        
        $params = array(
            'api_user' => $user,
            'api_key' => $pass,
            'to' => $to,
            'subject' => 'Message from Negotium Website (Notify)',
            'html' => $message,
            'text' => $message,
            'from' => 'hello@negotium.one',
        );

        $request = $url.'api/mail.send.json';
    
        // Generate curl request
        $session = curl_init($request);
    
        // Tell curl to use HTTP POST
        curl_setopt ($session, CURLOPT_POST, true);
    
        // Tell curl that this is the body of the POST
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
    
        // Tell curl not to return headers, but do return the response
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    
        // obtain response
        $response = curl_exec($session);
        curl_close($session);
    }
    $retval = send($to, $message);
    if ($retval == true) {
        $data="We have received your request to be notified. Thanks for being awesome!";
    } else {
        $data="Message could not be sent...";
    }
    echo json_encode($data);
?>