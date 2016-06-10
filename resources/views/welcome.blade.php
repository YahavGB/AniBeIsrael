@extends('layouts.master')
@section('content')

{{-- Steps --}}
<div class="step-container container-fluid first-step">
	<div class="row">
		<div class="col-xs-12 title">התחבר באמצעות Facebook</div>
	</div>
	<div class="row description">
		כדי להתחיל בהליך, עליך להתחבר באמצעות חשבון הFacebook שלך. <strong>אנו מחייבים כי לא נפרסם דבר בשמך ללא אישורך.</strong><br />
		<div class="note"><strong>שים לב:</strong> הרשאות פרסום נדרשות על מנת תמונת הפרופיל לחשבונך מהאתר. אולם, תוכל לבחור שלא לאשר הרשאות אלו לאתר ולהעלות התמונה בעצמך לחשבונך.</div>
	</div>
	@if (isset($facebookLoginUrl))
	{{-- Guest View --}}
	<div class="row action-container">
		<a href="{{{ $facebookLoginUrl }}}" title="התחבר באמצעות פייסבוק"><img src="{{{ asset('public/images/buttons/facebook-login.png') }}}" alt="" /></a>
	</div>
	{{-- / Guest View --}}
	@else
	{{-- User View --}}
	<div class="row action-container">
		<a href="{{{ $facebookLogoutUrl }}}" class="facebook-user">
			מחובר בתור <strong>{{{ $userData['name'] }}}</strong> (לחץ כדי להתנתק)</a>
	</div>
	{{-- / User View --}}
	@endif
</div>

<div class="container-fluid step-container">
	<div class="row">
		{{-- Second Step --}}
		<div class="col-md-6">
			<div class="second-step">
				<div class="title">הפעל את הפילטר</div>
				@if (!isset($userData))
				{{-- Guest View --}}
				<div class="action-container">
					<div class="profile-picture center-block" style="background: url('{{{ asset('public/images/misc/guest-profile-picture.png') }}}'); width: 160px; height: 160px;">
						<a href="javascript: void(0);" id="profile-picture-filter-button" class="action-button">לחץ כאן</a>
					</div>
				</div>
				{{-- / Guest View --}}
				@else
				{{-- User View --}}
				<div class="action-container">
					<div class="profile-picture center-block" style="background: url('https://graph.facebook.com/{{{ $userData['id'] }}}/picture?type=normal') no-repeat; background-size: 100%; width: 160px; height: 160px;">
						<a href="javascript: void(0);" id="profile-picture-filter-button" class="action-button">לחץ כאן</a>
						<a href="javascript: void(0);" id="profile-picture-filter-done-button" class="action-button hide">הצג</a>
						<div class="hide loading-anim">
    						<div class="cssload-container">
                            	<div class="cssload-tube-tunnel"></div>
                            </div>
							טוען, אנא המתן...
						</div>
						<div class="overlay hide"></div>
					</div>
				</div>
				{{-- / User View --}}
				@endif
			</div>
		</div>
		
		{{-- Third Step --}}
		<div class="col-md-6">
			<div class="third-step">
				<div class="title">העלה ושתף</div>
				<div class="explaination">
					אנא התחבר באמצעות פייסבוק על להוריד ולשתף את תמונת הפרופיל החדשה שלך.
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')
	<script type="text/javascript">
	$(function() {
		IBIApp.userData = {!! isset($userData) ? json_encode($userData) : '{}' !!};
		IBIApp.baseUrl = "{!! url('/') !!}";
		IBIApp.initWelcomePage();
	});
	</script>
@endsection