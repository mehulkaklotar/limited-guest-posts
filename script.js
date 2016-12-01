var limited_guest_posts;
( function( $ ){
    limited_guest_posts = {
        init: function() {
            var is_user_logged_in = params.is_user_logged_in || false;
            if( ! is_user_logged_in ) {
                var is_single = params.is_single || false;
                if( is_single ) {
                    var post_id = params.post_id || 0;
                    var cookie = limited_guest_posts.readCookie('mlp_single_posts');
                    if( cookie != null ) {
                        var cookie_arr = cookie.split(",");
                        var cookie_size = cookie_arr.length;
                        if( cookie_arr.indexOf(post_id) == -1 ) {
                            cookie = cookie + ',' + post_id;
                            limited_guest_posts.createCookie('mlp_single_posts',cookie,30);
                            cookie_size = cookie_size + 1;
                        }
                        if( cookie_size > 3 ) {
                            window.location.href = params.registration_url;
                        }
                    } else {
                        limited_guest_posts.createCookie('mlp_single_posts',post_id,30);
                    }
                }
            } else {
                limited_guest_posts.eraseCookie('mlp_single_posts');
            }
        },
        createCookie : function (name,value,days) {
            if (days) {
                var date = new Date();
                date.setTime(date.getTime()+(days*24*60*60*1000));
                var expires = "; expires="+date.toGMTString();
            }
            else var expires = "";
            document.cookie = name+"="+value+expires+"; path=/";
        },
        readCookie : function (name) {
            var nameEQ = name + "=";
            var ca = document.cookie.split(';');
            for(var i=0;i < ca.length;i++) {
                var c = ca[i];
                while (c.charAt(0)==' ') c = c.substring(1,c.length);
                if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
            }
            return null;
        },
        eraseCookie : function (name) {
            limited_guest_posts.createCookie(name,"",-1);
        }

    }
    $( document ).ready( function() { limited_guest_posts.init(); } );
})( jQuery );