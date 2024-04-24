<!DOCTYPE html>
<html>
<head>
    <title>Red template</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.6.1/css/bulma.css" />
</head>
<body>
@include('header')
@if(!$cv)
        <h2>Choose a CV title</h2>
        <!-- form to add CV title -->
        <form action="/add-cv" method="post">
                {{ csrf_field() }}
                <input type="text" name="cv_title" placeholder="CV title...">
                @if($errors->has('cv_title'))
                <p class="help is-danger">{{ $errors->first('cv_title') }}</p>
                @endif
                <input type="submit" value="Add a CV title">
        </form>

@else
        <h2>{{ $cv->title }}</h2>
        
        <!-- form to add professional experience -->
        <form action="/add-professional-experience" method="post">
        {{ csrf_field() }}

        <p>Add professional Experience</p>

        <input type="text" name="name" placeholder="Name..." value="{{ old('name') }}">
        @if($errors->has('name'))
                <p class="help is-danger">{{ $errors->first('name') }}</p>
        @endif

        <input type="text" name="location" placeholder="Location..." value="{{ old('location') }}">
        @if($errors->has('location'))
                <p class="help is-danger">{{ $errors->first('location') }}</p>
        @endif

        <input type="text" name="description" placeholder="Description..." value="{{ old('description') }}">
        @if($errors->has('description'))
                <p class="help is-danger">{{ $errors->first('description') }}</p>
        @endif

        <input type="text" name="start_date" placeholder="Start Date... (02/02/2020)" value="{{ old('start_date') }}">
        @if($errors->has('start_date'))
                <p class="help is-danger">{{ $errors->first('start_date') }}</p>
        @endif

        <input type="text" name="end_date" placeholder="End Date... (10/10/2021)" value="{{ old('end_date') }}">
        @if($errors->has('end_date'))
                <p class="help is-danger">{{ $errors->first('end_date') }}</p>
        @endif

        <input type="submit" value="Add professional Experience">
        </form>

        <!-- professional experiences list -->
        <h2>professional Experiences</h2>
        <ul>
                @forelse($professional_experiences as $professional_experience)
                <li>
                        <p>Name: {{ $professional_experience->name }}</p>
                        <p>Location: {{ $professional_experience->location }}</p>
                        <p>Description: {{ $professional_experience->description }}</p>
                        <p>Start date: {{ $professional_experience->start_date }}</p>
                        <p>Start date: {{ $professional_experience->end_date }}</p>
                </li>                    <form action="/delete-professional-experience" method="post">
                        @method('delete')
                        {{ csrf_field() }}
                        <input type="hidden" name="professional_experience_id" value="{{ $professional_experience->id }}">
                        <input type="submit" value="Delete professional Experience">
                </form>
                @empty
                <li>No professional experiences added yet.</li>
                @endforelse
        </ul>
    
        <!-- form to add academic experience -->
        <form action="/add-academic-experience" method="post">
        {{ csrf_field() }}

        <p>Add Academic Experience</p>

        <input type="text" name="name" placeholder="Name..." value="{{ old('name') }}">
        @if($errors->has('name'))
                <p class="help is-danger">{{ $errors->first('name') }}</p>
        @endif

        <input type="text" name="location" placeholder="Location..." value="{{ old('location') }}">
        @if($errors->has('location'))
                <p class="help is-danger">{{ $errors->first('location') }}</p>
        @endif

        <input type="text" name="description" placeholder="Description..." value="{{ old('description') }}">
        @if($errors->has('description'))
                <p class="help is-danger">{{ $errors->first('description') }}</p>
        @endif

        <input type="text" name="start_date" placeholder="Start Date... (02/02/2020)" value="{{ old('start_date') }}">
        @if($errors->has('start_date'))
                <p class="help is-danger">{{ $errors->first('start_date') }}</p>
        @endif

        <input type="text" name="end_date" placeholder="End Date... (10/10/2021)" value="{{ old('end_date') }}">
        @if($errors->has('end_date'))
                <p class="help is-danger">{{ $errors->first('end_date') }}</p>
        @endif

        <input type="submit" value="Add Academic Experience">
        </form>


        <!-- academic experiences list -->
        <h2>Academic Experiences</h2>
        <ul>
                @forelse($academic_experiences as $academic_experience)
                <li>
                        <p>Name: {{ $academic_experience->name }}</p>
                        <p>Location: {{ $academic_experience->location }}</p>
                        <p>Description: {{ $academic_experience->description }}</p>
                        <p>Start date: {{ $academic_experience->start_date }}</p>
                        <p>Start date: {{ $academic_experience->end_date }}</p>
                </li>        
                        <form action="/delete-academic-experience" method="post">
                        @method('delete')        
                        {{ csrf_field() }}
                        <input type="hidden" name="academic_experience_id" value="{{ $academic_experience->id }}">
                        <input type="submit" value="Delete Academic Experience">
                </form>
                @empty
                <li>No academic experiences added yet.</li>
                @endforelse
        </ul>

        <!-- form to add hobby -->
        <form action="/add-hobby" method="post">
        {{ csrf_field() }}

        <p>Adding hobby</p>

        <input type="text" name="description" placeholder="New hobby..." value="{{ old('description') }}">
        @if($errors->has('description'))
                <p class="help is-danger">{{ $errors->first('description') }}</p>
        @endif

        <input type="submit" value="Add hobby">
        </form>

        <!-- hobbies list -->
        <ul>
                @forelse($hobbies as $hobby)
                <li>{{ $hobby->description }}</li>
                <form action="/delete-hobby" method="post">
                @method('delete')                
                {{ csrf_field() }}
                <input type="hidden" name="hobby_id" value="{{ $hobby->id }}">
                <input type="submit" value="Delete hobby">
                </form>
                @empty
                <li>No hobbies added yet.</li>
                @endforelse
        </ul>

        <!-- logout -->
        <a href="/logout" class="button">Log out</a>

        <!-- generate pdf CV -->
        <form action="/generate-cv" method="post">
                {{ csrf_field() }}
                <input type="submit" value="Generate a PDF CV">
        </form>
@endif
@include('footer')
</body>
</html>
