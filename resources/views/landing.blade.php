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
          <div class="tab" v-on:click="selected = 'signup'" :class="{'selected' : selected == 'signup'}">Sign up</div>
          <div class="tab" v-on:click="selected = 'unsubscribe'" :class="{'selected' : selected == 'unsubscribe'}">Unsubscribe</div>
        </div>
        <div id="form-holder">
          <!-- SIGN UP FORM -->
          <form id="signup-form" v-show="selected == 'signup'" method="POST" v-on:submit.prevent="submitSignupForm">
            @csrf
            <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
            <div class="form-group">
              <label for="phoneNumber">Phone number</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">+1</div>
                </div>
                <input type="tel" class="form-control" id="phoneNumber" name="phoneNumber" v-model="phoneNumber" aria-describedby="phoneHelp" placeholder="">
              </div>
              <small id="phoneHelp" class="form-text text-muted">Your phone number won’t be used for anything except sending news alerts. If you text us back, we may engage in a conversation about the news.</small>
            </div>
            <div class="form-group">
              <label for="optionalName">Name</label>
              <input type="text" class="form-control" id="optionalName" name="optionalName" v-model="optionalName" placeholder="Tommy Trojan" aria-describedby="nameHelp">
              <small id="nameHelp" class="form-text text-muted">Providing your name is totally optional.</small>
            </div>
            {!! ReCaptcha::htmlFormSnippet() !!}
            <button type="submit" class="btn btn-success mt-2">Subscribe</button>
            <div v-if="successfulSignup" class="text-success pt-2">You’re now signed up for alerts! 🎉</div>
          </form>

          <!-- UNSUBSCRIBE FORM -->
          <form id="unsubscribe-form" v-if="selected == 'unsubscribe'" method="POST" v-on:submit.prevent="submitUnsubscribeForm">
            @csrf
            <validation-errors :errors="validationErrors" v-if="validationErrors"></validation-errors>
            <div class="form-group">
              <label for="phoneNumber">Enter the phone number you used to sign up:</label>
              <div class="input-group mb-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">+1</div>
                </div>
                <input type="tel" class="form-control" name="unsubscribePhone" id="unsubscribePhone" aria-describedby="unsubPhoneHelp" v-model="unsubscribePhone" placeholder="">
              </div>
              {{-- <small id="unsubPhoneHelp" class="form-text text-muted">You’ll get one last text confirming you unsubscribed.</small> --}}
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-danger">Unsubscribe</button>
            </div>
            <div v-if="successfulUnsub" class="text-success pt-2">OK, you’re unsubscribed. 👋</div>
          </form>

    </div>
  </div>

<figure id="homepage-graphic">
  <img src="{{asset('homepage-mockup.png')}}">
</figure>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.1.3/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.min.js"></script>

<script>
Vue.component('validation-errors', {
  data(){
    return {

    }
  },
  props: ['errors'],
  template: `<div v-if="validationErrors" class="form-group">
  <div v-for="(value, key, index) in validationErrors" id="message" class="text-danger mb-2">
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
      selected:"signup",
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
      successfulReset:false,
      recaptchaResponse:false
    }
  },
  watch:{
    selected:function(){
      this.validationErrors = "";
    }
  },
  methods: {
    submitSignupForm(){
      var self = this;
      self.successfulSignup = false;
      self.validationErrors = "";
      self.recaptchaResponse = document.getElementById("g-recaptcha-response").value;

      axios({
        method:"post",
        url:"/subscribe",
        data:{
          phoneNumber: self.phoneNumber,
          optionalName: self.optionalName,
          recaptchaResponse: self.recaptchaResponse
        },
      }).then(response => {
        self.successfulSignup = true;
      }).catch(error => {
        if (error.response.status == 422){
          self.validationErrors = error.response.data.errors;
        }
      })
    },
    submitUnsubscribeForm(){
      var self = this;
      self.successfulUnsub = false;
      self.validationErrors = "";

      axios({
        method:"post",
        url:"/unsubscribe",
        data:{
          unsubscribePhone: self.unsubscribePhone
        },
      }).then(response => {
        self.successfulUnsub = true;
      }).catch(error => {
        if (error.response.status == 422){
          self.validationErrors = error.response.data.errors;
        }
        if (error.response.status == 404){
          self.validationErrors = "That phone number isn’t subscribed to alerts… so there’s no way to unsubscribe it!"
        }
      })
    }
  }
});
</script>

@endsection
