@extends('layouts.app')

@section('content')

    <sections-form-component
        @if($section) :section='@json($section)' @endif
        locale_sections = '{{ __("locale.sections") }}'
        locale_users = '{{ __("locale.users") }}'
        locale_name = '{{ __("locale.name") }}'
        locale_email = '{{ __("locale.email") }}'
        locale_password = '{{ __("locale.password") }}'
        locale_description = '{{ __("locale.description") }}'
        locale_logo = '{{ __("locale.logo") }}'
        locale_send = '{{ __("locale.send") }}'
    />

@endsection