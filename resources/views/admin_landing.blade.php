@extends('layouts.base')

@section("pagetitle") USC news wherever you are. @endsection

@section("content")

  <nav>
    <a href="//uscannenbergmedia.com"><img id="logo" src="{{asset('FB horizontal lockup.png')}}" alt="USC Annenberg Media"></a>
  </nav>

  <main id="landingApp">
    <section id="description">
      <h1 id="keep-up">Keep up, wherever you are.</h1>
      <h5 id="we-promise">Sign up for Annenberg Media text alerts and get the USC news that matters to you. We promise we’ll only text you when it’s important.</h5>

      @if (isset($message) && isset($status))
        <div id="message" class="text-{{$status}} mt-3">
          {{$message}}
        </div>
      @endif

      @if(Auth::check())
      </p><a href="/dashboard" class="text-primary font-weight-bold d-block mt-3">🏡 Hi, {{Auth::user()->fname}}. Return to Dashboard</a>
      @endif
    </section>

      <div id="form-with-tabs">
        <div id="tabs">
          <div class="tab" id="admin-tab" v-on:click="selected = 'admin'" :class="{'selected' : selected == 'admin' || selected == 'request' || selected =='passwordReset'}">Admin login</div>
        </div>
        <div id="form-holder">

          <!-- ADMIN LOGIN -->
          <form id="admin-login-form" v-if="selected == 'admin'" method="POST" action="{{ route('login') }}">
            @csrf
            <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
            <div class="form-group">
              <label for="adminEmail">Email</label>
              <input type="email" class="form-control" id="adminEmail" name="adminEmail" required placeholder="ttrojan@usc.edu">
            </div>

            <div class="form-group">
              <label for="adminPass">Password</label>
              <input type="password" class="form-control" id="adminPass" name="adminPass" required>
            </div>

            <div class="form-row">
              <button type="submit" class="btn btn-success">Sign in</button>
              {{-- <div class="form-check form-check-inline ml-2">
              <input class="form-check-input" type="checkbox" value="remember" id="rememberMe" {{ old('rememberMe') ? 'checked' : '' }}>
              <label class="form-check-label" for="rememberMe">
              Keep me signed in
            </label>
          </div> --}}
        </div>

        <div class="form-group mt-3">
          <p><a v-on:click="selected = 'passwordReset'; validationErrors = ''">Forgot your password?</a></p>
          <p>If you don’t have a login, <a v-on:click="selected = 'request'; validationErrors = ''">request one</a>. →</p>
        </div>
      </form>

      <!-- PASSWORD RESET -->
      <form id="password-reset-request-form" v-if="selected == 'passwordReset'" method="POST" v-on:submit.prevent="submitPWReq">
        @csrf
        <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
        <div v-if="!successfulReset">
          <div class="form-group">
            <p><a v-on:click="selected = 'admin'; validationErrors = ''">← Nevermind… I remember my password</a></p>
          </div>

          <div class="form-group">
            <label for="resetEmail">Enter the email address you use to sign in:</label>
            <input type="text" name="resetEmail" class="form-control" id="resetEmail" v-model="resetEmail">
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary">Reset password</button>
          </div>
        </div>
        <div v-if="successfulReset">
          <p><a v-on:click="selected = 'admin'; validationErrors = ''">← Return</a></p>
          <h4 class="mt-2">Check your email for a reset link!</h4>
        </div>
      </form>

      <!-- REQUEST ACCESS -->
      <form id="account-request-form" v-if="selected == 'request'" method="POST" v-on:submit.prevent="submitAcctReq">
        @csrf
        <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
        <div class="form-group">
          <p><a v-on:click="selected = 'admin'; validationErrors = ''">← Nevermind… I already have an account</a></p>
        </div>

        <div class="form-group">
          <label for="requestFirst">First name</label>
          <input type="text" name="requestFirst" class="form-control" id="requestFirst" v-model="requestFirst">
        </div>

        <div class="form-group">
          <label for="requestLast">Last name</label>
          <input type="text" name="requestLast" class="form-control" id="requestLast" v-model="requestLast">
        </div>

        <div class="form-group">
          <label for="requestEmail">Email</label>
          <input type="text" name="requestEmail" class="form-control" id="requestEmail" placeholder="ttrojan@usc.edu" v-model="requestEmail">
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Request account</button>
          <small class="form-text text-muted mt-2">Accounts are only for Annenberg Media staff, obviously. </small>
          <div v-if="successfulAcctReq" class="text-success pt-2">OK, your request was submitted. You’ll be notified by email once an editor approves it.</div>
        </div>
      </form>

    </div>
  </div>

<figure id="homepage-graphic">
  <img src="{{asset('homepage-mockup.png')}}">
</figure>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<script>
Vue.component('validation-errors', {
  data(){
    return {

    }
  },
  props: ['errors'],
  template: `<div v-if="validationErrors" class="form-group">
  <div v-for="(value, key, index) in validationErrors" id="message" class="text-danger">
  @{{ value }}
  </div>
  </div>`,
  computed: {
    validationErrors(){
      let errors = Object.values(this.errors);
      errors = errors.flat();
      return errors;
    }
  }
});

const landingApp = new Vue({
  el: '#landingApp',
  data:function(){
    return {
      selected:"admin",
      validationErrors:"",
      phoneNumber:"",
      optionalName:"",
      unsubscribePhone:"",
      requestFirst:"",
      requestLast:"",
      requestEmail:"",
      resetEmail:"",
      successfulSignup:false,
      successfulUnsub:false,
      successfulAcctReq:false,
      successfulReset:false
    }
  },
  methods: {
    submitAcctReq(){
      var self = this;
      self.validationErrors = "";
      axios({
        method:"post",
        url:"/request",
        data:{
          requestFirst: self.requestFirst,
          requestLast:self.requestLast,
          requestEmail: self.requestEmail
        },
      }).then(response => {
        self.successfulAcctReq = true;
      }).catch(error => {
        if (error.response.status == 422){
          self.validationErrors = error.response.data.errors;
        }
      })
    },
    submitPWReq(){
      var self = this;
      self.validationErrors = "";
      axios({
        method:"post",
        url:"{{route('createResetToken')}}",
        data:{
          resetEmail:self.resetEmail
        },
      }).then(response => {
        self.successfulReset = true;
        console.log(response);
      }).catch(error => {
        if (error.response.status == 422){
          console.log(response);
          self.validationErrors = error.response.data.errors;
        }
      })
    }
  }
});
</script>

@endsection
