<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
</head>
    <body>
    <?php  $mail=str_replace('[[page_name]]',$page_name,$content); ?>
   
        {!! $mail !!}
    </body>
</html>
