(function(b){var a=function(){function c(){}return{init:function(){var d=jQuery(".save-search");d.on("click",function(){var e=[];e.push({name:"action",value:"property_alert_action"});e.push({name:"security",value:MDAjax.security});b.ajax({type:"POST",url:MDAjax.ajaxurl,data:e,dataType:"json"}).done(function(f){if(f.is_loggedin==0){RegisterForm.init()}})})}}}();b(window).load(function(){})})(jQuery);
