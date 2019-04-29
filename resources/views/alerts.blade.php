@extends('layouts.app')

@section('pagetitle') Send an alert @endsection

@section('page')

<h1>@yield('pagetitle')</h1>

<div id="alert-app" class="mt-4">

  {{-- ALERT COMPOSITION FORM --}}
  <form id="alert-composer" action="{{url("/alerts/send")}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="phoneNumber">Content</label>
      <textarea class="form-control" id="alertText" name="alertText" aria-describedby="alertHelp" v-on:keyup="updateMessage" v-on:change="updateMessage"></textarea>
      <small id="alertHelp" class="form-text text-muted"><span v-html="alertLength" v-bind:class="lengthClass"></span><span class="text-muted">/160. For some users, alerts longer than 160 characters may be split into multiple messages.</span></small>
      <div class="text-danger">{{$errors->first('alertText')}}</div>
    </div>
    <div class="form-group">
      <label for="alertImage">Image</label>
      <div class="custom-file">
        <input type="file" class="custom-file-input" name="alertImage" accept="image/*" id="alertImage" v-on:change="loadFile">
        <label class="custom-file-label" for="alertImage">Choose image</label>
        <small id="imageHelp" class="form-text text-muted">The image cannot be larger than 5 MB.</small>
      </div>
      <div class="text-danger">{{$errors->first('alertImage')}}</div>
    </div>
    <div class="form-group">
      {{-- <div id="test-message-btn" class="text-primary">Send a test message</div> --}}
      <button type="submit" class="btn btn-danger mt-2">Send</button>
    </div>
  </form>

  {{-- ALERT PREVIEW --}}
  <div id="alert-preview" v-if="messageContent.length > 0">
    <h3>Preview</h3>
      <div class="messages">
        <div class="message from-them" v-html="messageContent"></div>
        <img class="message from-them inVue" v-show="messageImage" :src="messageImage" id="message-image"></img>
      </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script>

  let alertComposerApp = new Vue({
    el:"#alert-app",
    data:function(){
      return {
        alertLength:0,
        messageContent:"",
        messageImage:""
      }
    },
    computed:{
      lengthClass:function(){
        if (this.alertLength < 130){
          return "text-muted"
        } else if (this.alertLength < 160){
          return "text-warning"
        } else {
          return "text-danger"
        }
      }
    },
    mounted:function(){
      bsCustomFileInput.init();
    },
    methods:{
      updateMessage:function(event){
        this.alertLength = event.target.value.length;
        this.messageContent = event.target.value;
      },
      loadFile:function(event) {
        this.messageImage = URL.createObjectURL(event.target.files[0]);

        URL.revokeObjectURL(event.target.files[0]);
      }
    }
  })
</script>

@endsection
