<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<body>
    <p>hello{{$formData['user']->name}}</p>
<h1>you have requested to chang password</h1>  

<p>please click the link give below to reset password.</p>
<a href="{{route('reset_password',$formData['token'])}}">click hear</a>

</body>
</html>