@extends('layouts.admin')

@section('content')
<br>

<section class = "content">   
    @include('investigator/mainheader')
    <!------------------------ end top part ---------------->  
<!DOCTYPE html>
<html>
<head>
  <!-- Include any required CSS stylesheets -->
  <style>
    .circle {
      display: inline-block;
      width: 12px;
      height: 12px;
      background-color: red;
      border-radius: 50%;
      margin-right: 5px;
    }
    .hidden {
      display: none;
    }
    .updated {
      background-color: yellow !important;
    }
  </style>
</head>
<body>
  <table>
    <tr>
      <th>First Set of Values</th>
      <th>Second Set of Values</th>
    </tr>
    <tr>
      <td>
        @foreach ($firstSetValues as $value)
          <div class="draggable">{{ $value }}</div>
        @endforeach
      </td>
      <td>
        <div class="droppable">
          @foreach ($secondSetValues as $label)
            <div class="dropped-label">
              <span class="circle"></span>
              <span class="label-text">{{ $label }}</span>
              <div class="hidden">
                <textarea class="textarea"></textarea>
                <button class="update-btn">Update</button>
              </div>
            </div>
          @endforeach
        </div>
      </td>
    </tr>
  </table>

  <!-- Include jQuery library -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Include jQuery UI library -->
  <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".draggable").draggable({
        helper: "clone",
        revert: "invalid"
      });

      $(".droppable").droppable({
        drop: function(event, ui) {
          var value = $(ui.helper).text();
          var $droppedLabel = $('<div class="dropped-label">' +
                                  '<span class="circle"></span>' +
                                  '<span class="label-text">' + value + '</span>' +
                                  '<div class="hidden">' +
                                  '<textarea class="textarea"></textarea>' +
                                  '<button class="update-btn">Update</button>' +
                                  '</div>' +
                                '</div>');
          $(this).append($droppedLabel);

          $droppedLabel.find(".circle").click(function() {
            $(this).siblings("div.hidden").toggleClass("hidden");
          });

          $droppedLabel.find(".update-btn").click(function() {
            var $hiddenDiv = $(this).siblings("div.hidden");
            $hiddenDiv.addClass("hidden");
          });

          $droppedLabel.find(".label-text").click(function() {
            var $textarea = $(this).siblings("div.hidden").find(".textarea");
            $textarea.val($(this).text());
          });
        }
      });
    });
  </script>
</body>
</html>

@endsection