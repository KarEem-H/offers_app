<!DOCTYPE html>
<html>
<head>
    <title>Mail</title>
</head>
<body>
@php
$mail=str_replace('[[name]]',$d['name'],setting('notification.mail'));
$mail=str_replace('[[email]]',$d['email'],$mail);
@endphp
{!!$mail!!}
</body>
</html>
