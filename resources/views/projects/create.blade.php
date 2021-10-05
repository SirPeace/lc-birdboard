<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h1>{{ config('app.name') }}</h1>

    <form method="POST" action="/projects">
        @csrf

        <div>
            <div>
                <label for="create-project-form__title">Title</label>
            </div>
            <input type="text" name="title" id="create-project-form__title" value="{{ old('title') }}">
            @error('title') <div style="color: crimson">{{ $message }}</div> @enderror
        </div>

        <div>
            <div>
                <label for="create-project-form__descrpition">Descrpition</label>
            </div>
            <textarea name="description" id="create-project-form__descrpition" value="{{ old('description') }}"></textarea>
            @error('description') <div style="color: crimson">{{ $message }}</div> @enderror
        </div>

        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>
