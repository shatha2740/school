
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>رسالة جديدة - Academics Academy</title>
</head>
<body style="font-family:Arial,sans-serif; background:#f4f7fb; padding:24px; color:#243247;">
    <div style="max-width:650px; margin:auto; background:#fff; padding:25px; border-radius:12px;">
        <h2 style="color:#1b4965;">رسالة جديدة من نموذج التواصل</h2>

<p>
    <strong>اسم المرسل:</strong>
    {{ $info['fname'] }} {{ $info['lname'] }}
</p>

        <p><strong>إيميل المرسل:</strong> {{ $info['email'] }}</p>

<p><strong>رقم المرسل:</strong> {{ $info['tel'] }}</p>


        <hr>

        <p><strong>الرسالة:</strong></p>
        <div style="white-space:pre-wrap;">{{ $info['message'] }}</div>

        @if (!empty($info['file']))
            <p style="margin-top:24px;">
                أرفق المرسل صورة مع هذه الرسالة.
                ستجدين الصورة كمرفق في البريد الإلكتروني.
            </p>
        @endif
    </div>
</body>
</html>
