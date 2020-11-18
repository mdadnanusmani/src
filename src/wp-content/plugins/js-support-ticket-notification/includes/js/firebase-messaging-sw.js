importScripts('https://www.gstatic.com/firebasejs/5.8.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/5.8.2/firebase-messaging.js');
var messagingSenderId="";
var myId = get_sw_url_parameters( 'messagingSenderId' );
function get_sw_url_parameters( param ) {
  var vars = {};
  self.location.href.replace( self.location.hash, '' ).replace( 
      /[?&]+([^=&]+)=?([^&]*)?/gi, 
      function( m, key, value ) { 
          vars[key] = value !== undefined ? value : '';
      }
  );
  if( param ) {
      return vars[param] ? vars[param] : null;    
  }
  return vars;
}
firebase.initializeApp({
  'messagingSenderId': myId  
});
const initMessaging = firebase.messaging();
self.addEventListener('push', function (event) {
  var eventData = event.data.text();
  var obj = JSON.parse(eventData); 
  var title = obj.notification.title;
  var options = {
    body: obj.notification.body, 
    icon: obj.notification.icon,
    data: obj.data,
  };
  event.waitUntil(self.registration.showNotification(title, options,tag));
});
self.addEventListener('notificationclick', function (event) {
  event.notification.close();
  event.waitUntil(
    clients.openWindow(event.notification.data.link)
  );
});