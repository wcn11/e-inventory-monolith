<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Connecting Accurate</title>
</head>
<body>

<script>
    {{--let query = window.location.hash.replace('#', '?')--}}

    {{--const url = new URL( window.location.protocol + "//" + window.location.host + query);--}}
    {{--const params = new URLSearchParams(url.search);--}}
    {{--// console.log(params.get('access_token') )--}}

    {{--(async () => {--}}
    {{--    await fetch('{{ env('ACCURATE_URL_AUTHORIZE') }}', {--}}
    {{--        method: 'POST',--}}
    {{--        headers: {--}}
    {{--            'Accept': 'application/json',--}}
    {{--            'Content-Type': 'application/json',--}}
    {{--            'Authorization': "Bearer " + "{{ auth()->user()->api_token }}"--}}
    {{--        },--}}
    {{--        body: JSON.stringify({--}}
    {{--            access_token: params.get('access_token'),--}}
    {{--            token_type: params.get('token_type'),--}}
    {{--            expires_in: params.get('expires_in'),--}}
    {{--            user: params.get('user')})--}}
    {{--    }).then(res => res.json())--}}
    {{--        .then(res => console.log(res));--}}
    {{--})();--}}


</script>
</body>
</html>
