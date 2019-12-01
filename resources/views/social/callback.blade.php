<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Callback</title>
</head>
<body>
    <script>
        window.opener.postMessage({token: "{{$token}}"}, "{{env("APP_URL")}}");
        window.close();
    </script>
</body>
</html>
