<!DOCTYPE html>
<html>
<head>
    <title>Kode OTP Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f5; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #0f172a; margin-top: 0; text-align: center;">Reset Password MineCart</h2>
        <p style="color: #475569; font-size: 16px; line-height: 1.5;">Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <p style="font-size: 14px; color: #64748b; margin-bottom: 10px;">Kode OTP Anda:</p>
            <div style="font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #3dcec4; background: #f8fafc; padding: 15px; border-radius: 8px; display: inline-block;">
                {{ $otp }}
            </div>
        </div>
        
        <p style="color: #475569; font-size: 14px; line-height: 1.5; text-align: center;">
            Kode OTP ini berlaku selama 15 menit.<br>
            Jika Anda tidak meminta reset password, abaikan email ini.
        </p>
        
        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">
            &copy; {{ date('Y') }} MineCart. All rights reserved.
        </p>
    </div>
</body>
</html>
