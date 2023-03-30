<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
    <body>
   <?php  $mail=str_replace('[[user_name]]',$name,$content); ?>
   
        {!! $mail !!}
    </body>
</html>
