var jsst_subscription_token = null;
var sessionid = js_ticket_notify.ticket_notify_session;
if(sessionid == 1){
    jQuery.post(
        js_ticket_notify.ajaxurl,
        {action:"jsticket_ajax",jstmod:"notification",task:"updateUserDevice"},
        function(data){
            console.log(data);
            if(data){
                console.log("Update Success");
            }else{
                console.log("Error update");
            }
        }
    ); 
}
if("navigator" in window && "serviceWorker" in navigator && "Notification" in window){
    Notification.requestPermission().then(function(permission){
        if(permission === "granted"){
            navigator.serviceWorker.register(js_ticket_notify.ticket_notify_message_js+"?messagingSenderId="+common.messagingSenderId_firebase)
            .then(function(reg){
                registerFirebaseToken(reg);
            })
            .catch(function(e){
                console.log(e);
            });
        }
    }).catch(function(e){
        console.log(e);
    });

    function registerFirebaseToken(reg){
        reg.pushManager.getSubscription().then(function(sub){
            var config = {
                apiKey: common.apiKey_firebase,
                authDomain: common.authDomain_firebase,
                databaseURL: common.databaseURL_firebase,
                projectId: common.projectId_firebase,
                storageBucket: common.storageBucket_firebase,
                messagingSenderId: common.messagingSenderId_firebase
            };

            firebase.initializeApp(config);
            
            const messaging = firebase.messaging();
            messaging.useServiceWorker(reg);
            messaging.requestPermission().then(function(){
                return messaging.getToken();
            }).then(function(token){
                jsst_subscription_token = token;
                if(sub == null){
                    reg.pushManager.getSubscription().then(function(sub){
                        jQuery.post(
                            js_ticket_notify.ajaxurl,
                            {action:"jsticket_ajax",jstmod:"notification",task:"subscribeForNotifications",token:jsst_subscription_token,endpoint:sub.endpoint},
                            function(data){
                                var data = JSON.parse(data);
                                if(data.code == "SUCCESS"){
                                    var notif = new Notification(data.notification.title,{
                                        body: data.notification.body,
                                        icon: data.notification.icon,
                                    });
                                    notif.onclick = function(){ this.close(); };
                                }else{
                                    console.log("Could not subscribe!");
                                }
                        });
                    });
                }
               //jQuery("body").append("<span style=\"position:fixed;top:50%;right:0;border:1px solid #ccc;background:#eee;padding:10px;cursor:pointer;\" onclick=\"unsubscribeNotifications();\">Unsubscribe Notifications</span>");
            }).catch(function(err){
                console.log(err);
            });

            messaging.onMessage(function(payload){
                reg.pushManager.getSubscription().then(function(sub){
                    var link = payload.data.link;
                    if(link.charAt(link.length - 1) == "/"){
                      link = link+"E_14"+btoa(sub.endpoint);
                    }else{
                      link = link+"/E_14"+btoa(sub.endpoint);
                    }
                    var notif = new Notification(payload.notification.title,{
                        body: payload.notification.body,
                        icon: payload.notification.icon,
                    });
                    notif.onclick = function(){
                        window.open(link);
                        // notif.close();
                    }
                });
            });

        });

    }

    function unsubscribeNotifications(){
        navigator.serviceWorker.getRegistration().then(function(reg){
            reg.pushManager.getSubscription().then(function(sub){
                jQuery.post(
                    js_ticket_notify.ajaxurl,
                    {action:"jsbulkoff_ajax",jstmod:"notification",task:"unsubscribeFromNotifications",token:jsst_subscription_token},
                    function(data){
                        alert("You must change notification permission to not subscribe again");
                });
                sub.unsubscribe();
                reg.unregister();
            }).catch(function(err){
                //nothing
            });
        }).catch(function(err){
            //nothing
        });
    }
    
}
