<!DOCTYPE html>
<html>
        <head>
                <title>Login</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css" />
        </head>
        <body>
                @include('header')
                <h1>hello</h1>
                <form action="/templates" method="post">
                        {{ csrf_field() }}
                        <button type=submit name="submit" value="blue">Blue Template</button>
                </form>
                <form action="/templates" method="post">
                        {{ csrf_field() }}
                        <button type=submit name="submit" value="red">Red Template</button>
                </form>
                <a href="/logout" class="button">Log out</a>
                @include('footer')
        </body>
</html>