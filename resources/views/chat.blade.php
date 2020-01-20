<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chat</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css')}}">
    <style>
        .list-group {
            overflow-y: scroll;
            height: 400px;
        }
        ul{
            list-style: none;
            margin: 0;
            padding: 0;
            }

        ul li{
            border-top-right-radius: 20%;
            margin-bottom: 2px;
            margin-top: 2px;
            font-family: Helvetica, Arial, sans-serif;
            width: 50%;
            }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-4 text-center">Group Chat</h1>
        <div class="row justify-content-center" id="app">
            <div class="col-lg-6">
                <li class="list-group-item active">{{ auth()->user()->name}}
                <span class="badge badge-pill badge-success">@{{ numberOfUser}}</span></li>
                <div class="badge badge-pill badge-warning">@{{ typing }}</div>
                <ul class="list-group" v-chat-scroll>
                    <message-component v-for="value,index in chat.message"
                     :key="value.index"
                     :color= chat.color[index]
                     :user = chat.user[index]
                     :time = chat.time[index]>
                        @{{ value }}
                    </message-component>
                </ul>
                <input type="text" class="form-control" 
                placeholder="Enter Message" v-model="message"
                    @keyup.enter="send"
                    name="message_content">
            </div>
        </div>
    </div>

    <script src="{{  asset('js/app.js') }}"></script>
</body>

</html>