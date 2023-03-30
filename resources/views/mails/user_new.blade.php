<!DOCTYPE html>
<html>
<head>
    <title>you have registered</title>
</head>
<body>
@php
    $mail=str_replace('[[user_name]]',$d['user_name'],setting('notification.user_new'));
@endphp
{!!$mail!!}
</body>
</html>
