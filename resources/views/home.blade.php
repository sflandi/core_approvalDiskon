@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in! 
                    <br>
                    <h5>Hello Firebase</h5><br>
                    <a href="{{url('send')}}">Push Notifikasi 1 device</a><br>
                    <a href="{{url('sendArray')}}">Push Notifikasi >1 devices</a><br><br>
                    <a href="{{url('sendFcm')}}">Push Notifikasi Brozot FCM</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    const messaging = firebase.messaging();
    // Add the public key generated from the console here.
    messaging.getToken({vapidKey: "BIh4LayXioqhtNXtXRhbYCn6vHPUgTB_iidpiwrk2jpSVrRahkHaDdAKDBH8DF7q1PTRdTz43jPTSp0HfreELTA"});
    function sendTokenToServer(token){
        const user_id = '{{Auth::user()->id}}';
        // console.log(user_id)
        // console.log(token)
        axios.post('/approvaldiskon/api/save_token', {
            token: token,
            user_id: user_id
        })
        .then((response) => {
            console.log(response);
            console.log(token);
        }, (error) => {
            console.log(error);
        })
        // axios.post('/api/save_token', {
        //     token, user_id
        // }).then(res => {
        //     console.log(res);
        // });
    }
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken({vapidKey: 'BIh4LayXioqhtNXtXRhbYCn6vHPUgTB_iidpiwrk2jpSVrRahkHaDdAKDBH8DF7q1PTRdTz43jPTSp0HfreELTA'}).then((currentToken) => {
    if (currentToken) {
        sendTokenToServer(currentToken);
        // updateUIForPushEnabled(currentToken);
    } else {
        // Show permission request.
        // console.log('No registration token available. Request permission to generate one.');
        // Show permission UI.
        // updateUIForPushPermissionRequired();
        // setTokenSentToServer(false);
    }
    }).catch((err) => {
    console.log('An error occurred while retrieving token. ', err);
    // showToken('Error retrieving registration token. ', err);
    // setTokenSentToServer(false);
    });
</script>
@endsection
