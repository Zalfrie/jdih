@extends('layouts.login')

@section('content')
    <form class="login-form" action="/auth/login" method="POST">
        {{ csrf_field() }}
		<h3 class="form-title">Login to your account</h3>
		<div class="alert alert-danger display-hide">
			<button class="close" data-close="alert"></button>
			<span>
			Enter any email and password. </span>
		</div>
		<div class="form-group">
			<!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
			<label class="control-label visible-ie8 visible-ie9">Email</label>
			<div class="input-icon">
				<i class="fa fa-user"></i>
				<input class="form-control placeholder-no-fix" type="email" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}"/>
			</div>
		</div>
		<div class="form-group">
			<label class="control-label visible-ie8 visible-ie9">Password</label>
			<div class="input-icon">
				<i class="fa fa-lock"></i>
				<input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password"/>
			</div>
		</div>
		<div class="form-actions">
			<label class="checkbox">
			<input type="checkbox" name="remember" value="1"/> Remember me </label>
			<button type="submit" class="btn blue pull-right">
			Login <i class="m-icon-swapright m-icon-white"></i>
			</button>
		</div>
		<div class="login-options">
			<h4>Or login with</h4>
			<ul class="social-icons">
				<li>
					<a class="facebook" data-original-title="facebook" href="javascript:;">
					</a>
				</li>
				<li>
					<a class="twitter" data-original-title="Twitter" href="javascript:;">
					</a>
				</li>
				<li>
					<a class="googleplus" data-original-title="Goole Plus" href="javascript:;">
					</a>
				</li>
				<li>
					<a class="linkedin" data-original-title="Linkedin" href="javascript:;">
					</a>
				</li>
			</ul>
		</div>
		<div class="create-account">
			<p>
				 Don't have an account yet ?&nbsp; <a href="/auth/register" id="register-btn">
				Create an account </a>
			</p>
		</div>
	</form>
@endsection
