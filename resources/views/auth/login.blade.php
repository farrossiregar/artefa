@extends('layouts.app')

@section('content')
<img class="profile-img-cards" src="/images/toolbarmaumau.png" alt="" />
<div class="container">
<label class="flex-center">Login with your account</label>
    <div class="card card-container">
        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" method="POST" action="{{ route('login') }}">
            {{csrf_field()}}
            
            <span id="reauth-email" class="reauth-email"></span>
            <input type="text" name="username" class="form-control" placeholder="User Name" required autofocus>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Sign in</button>
        </form><!-- /form -->
    </div><!-- /card-container -->
</div><!-- /container -->
@endsection
