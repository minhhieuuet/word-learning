/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.3.4/firebase-messaging.js');

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
// Your web app's Firebase configuration
var firebaseConfig = {
  apiKey: "AIzaSyBMiAHZJOcIa_AfHjQlNm6JlCJhvTPxQoo",
  authDomain: "hieuminh-c69cc.firebaseapp.com",
  databaseURL: "https://hieuminh-c69cc.firebaseio.com",
  projectId: "hieuminh-c69cc",
  storageBucket: "hieuminh-c69cc.appspot.com",
  messagingSenderId: "1009335386108",
  appId: "1:1009335386108:web:66057c6eec16789985fc79"
};
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
  console.log('[firebase-messaging-sw.js] Received background message ', payload);
  // Customize notification here
  const notificationTitle = 'Background Message Title';
  const notificationOptions = {
    body: 'Background Message body.',
    icon: '/firebase-logo.png'
  };

  return self.registration.showNotification(notificationTitle,
      notificationOptions);
});