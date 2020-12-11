<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approval . Plaza Toyota</title>
    <!-- firebase integration started -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <!-- Insert these scripts at the bottom of the HTML, but before you use any Firebase services -->

    <!-- Firebase App (the core Firebase SDK) is always required and must be listed first -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js"></script>
    
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-database.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"></script>

    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-functions.js"></script>
    <!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-analytics.js"></script>

    <!-- Add Firebase products that you want to use -->
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase-firestore.js"></script>
    <script>
        // Your web app's Firebase configuration
        // For Firebase JS SDK v7.20.0 and later, measurementId is optional
        var firebaseConfig = {
            apiKey: "AIzaSyAGUKWnydzO6AcEUNNjD8lV_nUzg6f-4So",
            authDomain: "latihannotifikasi-144f9.firebaseapp.com",
            databaseURL: "https://latihannotifikasi-144f9.firebaseio.com",
            projectId: "latihannotifikasi-144f9",
            storageBucket: "latihannotifikasi-144f9.appspot.com",
            messagingSenderId: "428291801827",
            appId: "1:428291801827:web:e2af36478c4d9e8eba7bd6",
            measurementId: "G-J9KJEY396T"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        firebase.analytics();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
<h5>Hello Firebase</h5><br>
<a href="{{url('send')}}">Push Notifikasi 1 device</a><br>
<a href="{{url('sendArray')}}">Push Notifikasi >1 devices</a>
<script>
    const messaging = firebase.messaging();
    // Add the public key generated from the console here.
    messaging.getToken({vapidKey: "BIh4LayXioqhtNXtXRhbYCn6vHPUgTB_iidpiwrk2jpSVrRahkHaDdAKDBH8DF7q1PTRdTz43jPTSp0HfreELTA"});
    function sendTokenToServer(token){
        console.log(token)
        // axios.post('/api/saveToken', {
        //     token
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
</body>
</html>