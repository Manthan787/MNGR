<html>
<head>
    <title>{{ $test->name }} | Test</title>
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
            <a href="/tests/{{ $test->id }}/answers" class="btn btn-success">
              <span class="glyphicon glyphicon-check"></span>
              Answer Sheet
            </a>
            <a href="/admin#/Tests/all" class="btn btn-info">
              <span class="glyphicon glyphicon-folder-open"></span>
               View All
            </a>
        </div>
        <h3>{{ $test->name }}</h3>
        <h4>Marks: {{ $test->marks }}</h4>
      </div>
      <?php $i = 1; ?>
      @foreach($questions as $question)
      <div>
        <span class="count"><h5>{{ $i.")" }}</h5></span>
        <span class="question-title"><h5>{{ $question->question }}</h5></span>
      </div>
          <ol type="A" style="margin-bottom: 0">
            @if($test->layout === 'horizontal')
              @foreach($question->options as $index => $option)
                <li style="display:inline; margin-right:10px">
                  {{ chr(65+$index)."."." ".$option->option }}
                </li>
              @endforeach
            @endif
            @if($test->layout === 'vertical')
              @foreach($question->options as $index => $option)
                <li>
                  {{ $option->option }}
                </li>
              @endforeach
            @endif
          </ol>
      <?php $i++ ?>
      @endforeach
    </div>
</body>
</html>
