<div style="font-family: Helvetica,Arial,sans-serif;min-width:1000px;overflow:auto;line-height:2">
    <div style="margin:50px auto;width:70%;padding:20px 0">
        <div style="border-bottom:1px solid #eee">
            <a href="" style="font-size:1.4em;color: #00466a;text-decoration:none;font-weight:600">Jobs Pulse</a>
        </div>
        <p style="font-size:1.1em">Hi,</p>
        @if ($type === 'verification')
        <p>Thank you for choosing Jobs Pulse. Use the following OTP to complete your Sign Up procedures. OTP is valid for 5 minutes</p>
        @elseif ($type === 'password.reset')
        <p>Use the following OTP to reset your password. OTP is valid for 5 minutes</p>
        @endif
        <h2 style="background: #00466a;margin: 0 auto;width: max-content;padding: 0 10px;color: #fff;border-radius: 4px;">
            {{ $otp }}
            </h2>
        <p style="font-size:0.9em;">Regards,<br />Jobs Pulse</p>
        <hr style="border:none;border-top:1px solid #eee" />
        <div style="float:right;padding:8px 0;color:#aaa;font-size:0.8em;line-height:1;font-weight:300">
            <p>Jobs Pulse Inc</p>
            <p>1600 Amphitheatre Parkway</p>
            <p>California</p>
        </div>
    </div>
</div>
