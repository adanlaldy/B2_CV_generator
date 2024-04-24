<!DOCTYPE html>
<html>
        <head>
                <title>My account</title>
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css" />
        </head>
        <body>
                @include('header')
                <!-- Liste des cvs -->
                <h2>cvs: </h2>
                <ul>
                        @forelse($cvs_list as $cv)
                        <li>{{ $cv->title }}</li>
                        <form action="/update-cv" method="post">
                        @method('put')
                        {{ csrf_field() }}
                        <input type="hidden" name="cv_id" value="{{ $cv->id }}">
                        <input type="submit" value="Update CV">
                        </form>
                        <form action="/delete-cv" method="post">
                        @method('delete')
                        {{ csrf_field() }}
                        <input type="hidden" name="cv_id" value="{{ $cv->id }}">
                        <input type="submit" value="Delete CV">
                        </form>
                        <form action="/download-cv" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="cv_id" value="{{ $cv->id }}">
                        <input type="submit" value="Download CV">
                        </form>
                        @empty
                        <li>No cvs added yet.</li>
                        @endforelse
                </ul>
                @if(count($cvs_list) < 2)
                <form action="/my-account" method="post">
                        {{ csrf_field() }}
                        <button type=submit>Create CV</button>
                </form>
                @endif
                <a href="/logout" class="button">Log out</a>
                @include('footer')
        </body>
</html>
