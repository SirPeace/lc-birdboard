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

    <h2>{{ $project->title }}</h2>
    <p>{{ $project->description }}</p>
</body>
</html>
