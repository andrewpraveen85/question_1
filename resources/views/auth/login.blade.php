<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sign in</title>
        <link href="../../css/bootstrap.min.css" rel="stylesheet">
        <link href="../../css/signin.css" rel="stylesheet" type="text/css"/>
    </head>
    <body class="text-center">
        <main class="form-signin">
            <form method="POST" action="{{ route('login.confirm') }}">
                @csrf <!-- {{ csrf_field() }} -->
                <h1 class="h3 mb-3 fw-normal">Please sign in</h1>
                <div class="form-floating">
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com">
                    <label for="floatingInput">Email address</label>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{$errors->first('email')}}</span>
                    @endif
                </div>
                <div class="form-floating">
                    <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
                    <label for="floatingPassword">Password</label>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{$errors->first('password')}}</span>
                    @endif
                </div>
                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <p class="mt-5 mb-3 text-muted">&copy; 2023</p>
            </form>
        </main>
    </body>
</html>
