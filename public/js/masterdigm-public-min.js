(function(a){var c=function(){return{init:function(){a(".share-popup").click(function(b){var a=this.href;a.split("/");window.open(a,"","menubar=no,toolbar=no,resizable=yes,scrollbars=yes,width=585,height=511");b.preventDefault();return!1})}}}(),d=function(){return{init:function(){a(document).on("click",".print-pdf-action",function(b){b=a(this).attr("href");b=window.open(b,"print pdf","height=700,width=900");window.focus&&b.focus();return!1})}}}();a(window).load(function(){c.init();d.init();a('[data-toggle="tooltip"]').tooltip()})})(jQuery);
