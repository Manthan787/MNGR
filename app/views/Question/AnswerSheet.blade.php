<html>
<head>
    <title>{{ $test->name }} | Answer Sheet</title>
    <meta http-equiv="Content-Type"/>
     <style type="text/css" media="print">
        .print {
          visibility: hidden;
          display: none;
        }
     </style>
     <style type="text/css">
         .print {
           margin-top: 4px;
         }
         .count
         {
             float: left;
             margin-right: 2px;
         }
         .question-title
         {
             display: block;
             overflow: hidden;
         }

     </style>
     <link rel="stylesheet" href="{{ URL::asset("app/admin/css/bootstrap.min.css") }}" />
</head>
<body>
    <div class="container">
      <div align="center">
        <div class="print">
            <button type="button" onclick="window.print()" class="btn btn-primary">
              <span class="glyphicon glyphicon-print"></span>
              Print
            </button>
            <a href="/tests/{{ $test->id }}/show" class="btn btn-warning">
              <span class="glyphicon glyphicon-list-alt"></span>
              Question Paper
            </a>
        </div>
        <h3>{{ $test->name }}</h3>
        <h4>Marks: {{ $test->marks }}</h4>
     </div>
        <ul>
            @foreach($answers as $index => $answer)
            <li style="display:inline; margin-right:10px">{{++$index.". ".chr(65+$answer)}}</li>
            @endforeach
        </ul>
    </div>
</body>
</html>
