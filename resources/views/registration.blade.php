<!DOCTYPE html>
<html>
        <head>
                <title>Registration</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css" />
        </head>
        <body>
                @include('header')
                <form action="/registration" method="post">
                        {{ csrf_field() }}

                        <input type="text" name="first_name" placeholder="first name..." value="{{ old('first_name') }}">
                        <input type="text" name="last_name" placeholder="last name..." value="{{ old('last_name') }}">
                        <input type="email" name="email" placeholder="email..." value="{{ old('email') }}">
                        @if($errors->has('email'))
                                <p>{{ $errors->first('email') }}</p>
                        @endif
                        <input type="tel" name="phone_number" placeholder="phone number..." value="{{ old('phone_number') }}">
                        @if($errors->has('phone_number'))
                                <p>{{ $errors->first('phone_number') }}</p>
                        @endif
                        <input type="password" name="password" placeholder="password: ">
                        @if($errors->has('password'))
                                <p>{{ $errors->first('password') }}</p>
                        @endif
                        <input type="password" name="password_confirmation" placeholder="password confirmation...">
                        @if($errors->has('password_confirmation'))
                                <p>{{ $errors->first('password_confirmation') }}</p>
                        @endif
                        <input type="submit" value="Registration">
                </form>
                @include('footer')
        </body>
</html>