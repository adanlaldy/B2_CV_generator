<!DOCTYPE html>
<html>
        <head>
                <title>Login</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css" />
        </head>
        <body>
                @include('header')
                <form action="/login" method="post">
                    {{ csrf_field() }}
                    <input type="email" name="email" placeholder="email..." value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <p>{{ $errors->first('email') }}</p>
                    @endif
                    <input type="password" name="password" placeholder="password: ">
                    @if($errors->has('password'))
                        <p>{{ $errors->first('password') }}</p>
                    @endif
                    <input type="submit" value="Login">
                </form>
                @include('footer')
        </body>
</html>