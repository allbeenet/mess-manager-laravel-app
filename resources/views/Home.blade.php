@extends('app')
@section('title', 'Mess Manager')

@section('content')
<div class="as-app-body-content as-flex as-flex-h-center">
    <!-- authentication -->
    <div id="authentication" class="as-w-300px as-grow as-bg-white as-shadow as-p-10px as-rounded as-card">
        <div class="as-flex as-flex-center as-h-center as-mb-15px">
            <img width="200px" class="as-w-150px" src="{{asset("images/1.png")}}">
        </div>

        <input id="email" class="as-input" type="text" placeholder="ইমেইল">

        <Button class="as-button as-mt-10px as-w-100 as-dynamic-cursor" onclick="sendOTP()">
            পরবর্তী ধাপে যান
        </Button>
    </div>

    <!-- verify -->
    <div id="verify" class="as-grow as-bg-white as-shadow as-p-10px as-hide as-card" id="verify">
        <div class="as-flex as-flex-center as-h-center as-mb-15px">
            <img width="200px" class="as-w-150px" src="{{asset("images/2.png")}}">
        </div>

        <input id="otp" class="as-input" type="number" placeholder="ওটিপি">

        <Button class="as-button as-mt-10px as-w-100 as-dynamic-cursor" onclick="verifyOTP()">
            যাচাই করুন
        </Button>
    </div>

    <!-- registration -->
    <div class="as-grow as-bg-white as-shadow as-p-10px as-hide as-card" id="registration">
        <div class="as-flex as-flex-center as-h-center as-mb-15px">
            <img width="200px" class="as-w-150px" src="{{asset("images/3.png")}}">
        </div>

        <input id="messName" class="as-input" type="text" placeholder="মেসের নাম">

        <Button class="as-button as-mt-10px as-w-100 as-dynamic-cursor" onclick="register()">
            নিবন্ধন করুন
        </Button>
    </div>
</div>
@endsection

@section('script')
<script>
    var OTP = generateRandomNumber() //from asteroid-v1.js

    function sendOTP(){
        var email  = document.getElementById('email').value

        var isValidEmail = isEmail(email)

        if(email == ''){
            barToast.warning({text: 'Eamil is required'})
        }
        else if(isValidEmail){
            fireSendOTP(email)
        }
        else{
            barToast.error({text: 'Eamil is not valid'})
        }
    }

    function fireSendOTP(email){
        axios.post('/send-otp', {'email': email, 'otp': OTP})
        .then((res)=>{
            if(res.data['status'] == 200){
                authentication.classList.add('as-hide')
                verify.classList.remove('as-hide')
                barToast.success({text: OTP})
            }
            else{
                barToast.error({text: 'Failed to send OTP'})
            }
        })
        .catch((error)=>{
            barToast.error({text: 'Failed to send OTP'})
        })
    }

    function verifyOTP(){
        var otp    = document.getElementById('otp').value
        var email  = document.getElementById('email').value

        if(otp == ''){
            barToast.warning({text: 'OTP is required'})
        }
        else if(otp == OTP){
            authenticate(email)
        }
        else{
            barToast.error({text: 'OTP did not match'})
        }
    }

    function authenticate(email){
        axios.post('/authenticate', {'email': email})
        .then((res)=>{
            if(res.data['status'] == 200 && res.data['next_route'] == 'register'){
                registration.classList.remove('as-hide')
                verify.classList.add('as-hide')
            }
            else if(res.data['status'] == 200 && res.data['next_route'] == 'dashboard'){
                location.replace('/dashboard')
            }
            else{
                barToast.error({text: 'Authentication failed'})
            }
        })
        .catch((error)=>{
            barToast.error({text: 'Authentication failed'})
        })
    }

    function register(){
        var data
        var messName  = document.getElementById('messName').value
        var messEmail = document.getElementById('email').value

        if(messName == ''){
            barToast.warning({text: 'Mess name is required'})
        }
        else{
            data = {
                'mess_name': messName,
                'mess_email': messEmail,
            }

            axios.post('/register', data)
            .then((res)=>{
                if(res.data['status'] == 409){
                    barToast.info({text: 'Mess already exists'})
                }
                else if(res.data['status'] == 200 && res.data['next_route'] == 'dashboard'){
                    location.replace('/dashboard')
                }
                else{
                    barToast.error({text: 'Registration failed'})
                }
            })
            .catch((error)=>{
                barToast.error({text: 'Registration failed'})
            })
        }
    }
</script>
@endsection
