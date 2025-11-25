<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Validate</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin-partials.style')
</head>
<body>

    <div class="jumbotron text-center">
    <h1>User Replace Password MRapat</h1>
    <p>Reset Password</p> 
    </div>

    <a href="{{route('replace_password.index', [$data['user']->remember_token, $data['user']->email])}}" class="btn btn-primary col-md-12">  Reset Password Akun MRapat  </a>

</body>
</html>
