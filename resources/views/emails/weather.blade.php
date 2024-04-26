<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notice</title>
</head>
<body>
    <h1>Weather today</h1>
    Temperature: {{$data['current']['temp_c']}}
    Wind: {{$data['current']['wind_mph']}} m/s
    Hudimity: {{$data['current']['humidity']}}%
    Temperature: {{$data['current']['temp_c']}}
    Condition: {{$data['current']['condition']['text']}}
</body>
</html>