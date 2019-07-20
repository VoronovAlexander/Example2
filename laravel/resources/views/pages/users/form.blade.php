@extends('layouts.app')

@section('content')

    <users-form-component
        @if($user) :user='@json($user)' @endif
        locale_users = '{{ __("locale.users") }}'
        locale_name = '{{ __("locale.name") }}'
        locale_email = '{{ __("locale.email") }}'
        locale_password = '{{ __("locale.password") }}'
        locale_send = '{{ __("locale.send") }}'
    />

@endsection