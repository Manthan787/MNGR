<?php

?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="includes/youTube.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/themes/smoothness/jquery-ui.css" />
<!--<link rel="stylesheet" href="includes/youTube.css" /> -->

<div id="body">
    <div class="container" id="youtube_container">
      <div align="center">
          <img id="pre_preview_img" src="images/preview.png" class="img-responsive center-block">
          <div id="video_preview">
            <div class="alert alert-info" id="message"></div>
          </div>
      </div>
      <form class="form-inline">
        <div class="form-group">
            <label>Width (px)</label>
            <input type="text" id="youtube_width" class="form-control" value="640" />
        </div>
        <div class="form-group">
          <label>Height (px)</label>
          <input type="text" id="youtube_height" class="form-control" value="360" />
        </div>

        <div class="form-group">
          <label>YouTube URL</label>
          <input type="text" id="youtube_url" class="form-control" placeholder="YouTube Url..." />
        </div>

        <div class="form-group">
          <label>Title</label>
          <input type="text" id="youtube_title"  class="form-control" placeholder="Title" />
        </div>
      </form>
    </div>
</div>
<br />
<div align="center">
<button id="youtube_cancel" class="btn btn-default">Cancel</button>
<button id="youtube_insert" class="btn btn-primary">Insert and Close</button>
</div>
