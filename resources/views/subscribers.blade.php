@extends('layouts.app')

@section('pagetitle') Subscribers @endsection

@section('page')

<h1>@yield('pagetitle')</h1>

<div id="subscribers-page" class="mt-4">
  <h3 class="mt-2 border-top pt-3 pb-2">{{sizeof($subscribers)}} subscribers</h3>
  <div v-if="validationErrors" v-for="error in validationErrors" v-html="error[0]" class="text-danger mt-2 mb-2"></div>

  <table class="table table-striped table-responsive-sm">
    <thead>
      <tr>
        <th scope="col">Phone</th>
        <th scope="col">Name</th>
        <th scope="col">Subscriber since</th>
        @if(Auth::user()->super)
          <th scope="col"></th>
        @endif
      </tr>
    </thead>
    <tbody>
      @foreach($subscribers as $subscriber)
        <tr>
          <td>{{$subscriber->phone}}</td>
          <td>{{$subscriber->name}}</td>
          <td>{{date_format($subscriber->created_at->setTimezone('America/Los_Angeles'), "M j, Y")}}</td>
          @if(Auth::user()->super)
            <td><i class="far fa-trash-alt delete-icon"></i></td>
          @endif
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<script>
  let subscribersApp = new Vue({
    el:"#subscribers-page",
    data:function(){
      return {
        validationErrors:null
      }
    },
    methods:{
      deleteSubscriber:function(event){
        let userPhone = event.target.dataset.phone;
        let self = this;
        axios({
          method:"post",
          url:"/unsubscribe",
          data:{
            unsubscribePhone: userPhone
          },
        }).then(response => {
          document.location.reload();
        }).catch(error => {
          if (error.response.status == 422){
            self.validationErrors = error.response.data.errors;
            console.log(error.response.data.errors);
          }
        })
      }
    }
  })
</script>

@endsection
