@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $user->name }}'s profile
                </div>
                <div class="panel-body">
                    <center>
                        <img src="{{ Storage::url($user->avatar) }}" width="70px" height="70px" style="border-radius: 50%">
                    </center>
                    <p class="text-center" style="padding-top: 5px; font-style: italic">
                        {{ $user->profile->location }}
                    </p>
                    <p class="text-center" style="padding-top: 5px">
                        @if(Auth::id() == $user->id)
                            <a href="{{ route('profile.edit', $user->slug) }}" class="btn btn-lg btn-info">Edit profile</a>
                        @endif
                    </p>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    About me
                </div>
                <div class="panel-body">
                    <p class="text-center">
                        {{ $user->profile->about }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection