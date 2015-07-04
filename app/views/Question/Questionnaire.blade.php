<html>
<head>
    <title>{{ $test->name }}</title>
    <meta http-equiv="Content-Type" content="text/html;charset="utf-8" />
   <style>

   </style>
</head>
<body>
    <h3>{{ $test->name }}</h3>
    <h4>{{ $test->marks }}</h4>
    <ul>
        @foreach($questions as $question)
        <br>
        <li>
            <b>Q</b>{{ $question->question }}
            @foreach($question->options as $option)
            <li>{{ $option->option }}</li>
            @endforeach
        </li>
        <br>
        @endforeach
    </ul>
</body>
</html>