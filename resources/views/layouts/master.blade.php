<!DOCTYPE html>
<html>
    <head>
        <title>#AniBeIsrael</title>
        
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="owner" content="Quartz Technologies, Ltd." />
		<meta name="author" content="Yahav G. Bar" />
		<meta name="designer" content="Naor Attia" />
		<meta name="language" content="he" />
        <meta name="reply-to" content="campgain@anibeisrael.com" />
        <meta name="owner" content="Quartz Technologies, Ltd." />
        <meta name="url" content="http://anibeisrael.com" />
        <meta name="identifier-URL" content="http://anibeisrael.com" />
	
		<meta property="og:title" content="#AniBeIsrael" />
		<meta property="og:image" content="{{{ asset('public/images/logo.png') }}}" />
		 
		<meta name="apple-mobile-web-app-title" content="#AniBeIsrael">
        <meta name="apple-mobile-web-app-capable" content="yes">        		

        <link href="http://fonts.googleapis.com/earlyaccess/opensanshebrew.css" rel="stylesheet" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css">
        <link href="{!! asset('public/css/layout.css') !!}" rel="stylesheet" type="text/css">

		<link rel="stylesheet" href="//cdn.rawgit.com/morteza/bootstrap-rtl/v3.3.4/dist/css/bootstrap-rtl.min.css">
		<link href="{!! asset('public/css/layout-rtl.css') !!}" rel="stylesheet" type="text/css">
		@yield('styles')
		
		<script src="https://code.jquery.com/jquery-2.2.4.min.js"   integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="   crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js" type="text/javascript"></script>
        <script src="{{{ asset('public/scripts/app.js') }}}" type="text/javascript" charset="utf-8"></script>
    </head>
    <body>
    
    	{{-- Header --}}
    	<div class="header-container container-fluid">
    		<div class="row">
    			{{-- Title --}}
    			<div class="col-xs-7 header-title">
    				<a href="{{{ url('/') }}}" title="#AniBeIsrael Campgain Website">#<strong>AniBeIsrael</strong></a>
    			</div>
    			
    			{{-- Sharing --}}
    			<div class="col-xs-5 header-sharing-section">
    				{{-- Facebook sharing button --}}
    				<div class="fb-like" data-href="http://anibeisrael.com" data-layout="button_count" data-action="like" data-show-faces="true" data-share="false"></div>
    				<div class="fb-share-button" data-href="http://anibeisrael.com" data-layout="button_count" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fanibeisrael.com%2F&amp;src=sdkpreparse">Share</a></div>
    				
    				{{-- Twitter hashtag button --}}
    				<a href="https://twitter.com/intent/tweet?button_hashtag=AniBeIsrael" class="twitter-hashtag-button" data-size="large" data-url="http://anibeisrael.com"  data-lang="he">Tweet #AniBeIsrael</a>
    			</div>
    		</div>
    	</div>
    	
    	{{-- Content --}}
    	@yield('content')
    	
    	{{-- Footer --}}
    	<div class="footer-container container-fluid">
    		<div class="row">
    			<div class="col-sm-9">
    				Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br />
    			</div>
    			<div class="col-sm-3">
    				<a href="https://github.com/yahavgb/anibeisrael" target="_blank">
    					<img src="{{{ asset('public/images/misc/github.png') }}}" alt="Github" /></a>
    				{{--	&nbsp;
    				<a href=""><img src="{{{ asset('public/images/locale/en.png') }}}" alt="English" /></a>
    				&nbsp;
    				<a href=""><img src="{{{ asset('public/images/locale/he.png') }}}" alt="Hebrew" /></a>
    				--}} &nbsp;&middot;&nbsp; 
    				<a href="mailto: campgain@anibeisrael.com">יצירת קשר</a>
    			</div>
    		</div>
    	</div>
    	
    	{{-- Scripts --}}
       	<div id="fb-root"></div>
        <script>
              window.fbAsyncInit = function() {
                FB.init({
                  appId      : '{{{ env('FACEBOOK_APP_ID') }}}',
                  xfbml      : true,
                  version    : 'v2.6'
                });
              };
            
              (function(d, s, id){
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) {return;}
                 js = d.createElement(s); js.id = id;
                 js.src = "//connect.facebook.net/en_US/sdk.js";
                 fjs.parentNode.insertBefore(js, fjs);
               }(document, 'script', 'facebook-jssdk'));
            </script>
    
        
		<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
        @yield('scripts')
        
    </body>
</html>