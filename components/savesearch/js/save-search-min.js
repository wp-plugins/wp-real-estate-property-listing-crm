(function(b){var a=function(){function c(){}return{init:function(){var d=jQuery(".save-search");var e=jQuery(".label-ajax");b(document).on("click",".save-search",function(){var g=[];var h=b(this).data("post");var f=b(this).data("save-search");g.push({name:"action",value:"save_search_action"});g.push({name:"security",value:MDAjax.security});g.push({name:"data_post",value:h});g.push({name:"data_save_search_name",value:f});b(this).find(".btn-text").text("Saved Search");b(this).find(".glyphicon").toggleClass("glyphicon-star-empty glyphicon-star");b(this).toggleClass("btn-primary btn-success");b(this).toggleClass("save-search saved-search");e.html("Saving search...");b.ajax({type:"POST",url:MDAjax.ajaxurl,data:g,dataType:"json"}).done(function(i){e.html("!Done");e.html("");if(i.is_loggedin==0){RegisterForm.init()}})})}}}();b(window).load(function(){a.init()})})(jQuery);
