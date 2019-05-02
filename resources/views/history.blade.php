@extends('layouts.app')

@section('pagetitle') History @endsection

@section('page')

<form class="form-inline mb-3 float-right mr-3" method="get" action="{{url('/history')}}">
  <input class="form-control mr-sm-2" type="search" placeholder="Search alerts…" aria-label="Search alerts" name="search" value="{{$search}}">
  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>

<h1>@yield('pagetitle')</h1>

@if($search)
<p class="text-muted mt-2">Search results for “{{$search}}”</p>
@endif

<div id="history-app" class="mt-4">
  <div id="message-list">
    <ul class="list-group">
      @forelse($messages as $message)
        <li class="media list-group-item list-group-item-action d-flex justify-content-between align-items-center p-3">
          <div class="media-body">
            <p class="font-weight-bold my-0">{{$message->message}}</p>
            <p class="small mb-0">Sent at {{date_format(date_create($message->created_at), "h:m a")}} on {{date_format(date_create($message->created_at), "M j, Y")}} by {{$message->fname . " " . $message->lname}}</p>
          </div>
          <i class="far fa-eye" data-toggle="modal" data-target="#message-detail" data-message="{{$message->message}}" data-image="{{$message->mediaUrl}}"></i>
        </li>
      @empty
        <li class="media list-group-item d-flex justify-content-between align-items-center p-3">
          @if($search)<h4 class="mb-0">Sorry, there were no results for “{{$search}}” 😭</h4>
          @else<h4 class="mb-0">Nothing to show yet</h4>@endif
        </li>
      @endforelse
    </ul>

    {{ $messages->links() }}
  </div>

  <div class="modal fade" id="message-detail" tabindex="-1" role="dialog" aria-label="Preview message text" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Preview</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="messages mb-2 mx-auto">
            <div class="message from-them" id="message-text"></div>
            <img class="message from-them" id="message-image"></img>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>

<script>

  $('#message-detail').on('show.bs.modal', function (event) {
    console.log("Event triggered");
    var button = $(event.relatedTarget);
    var message = button.data('message');
    var image = button.data("image");
    console.log("message", message);
    console.log("image", image);

    var modal = $(this);

    modal.find('#message-text').text(message);
    modal.find('#message-image').attr("src", image);

    if (image){
      $("#message-image").show();
    } else {
      $("#message-image").hide();
    }
  });

</script>


@endsection
