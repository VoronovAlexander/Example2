@extends('layouts.app')

@section('content')

    <users-table-component
        locale_users = '{{ __("locale.users") }}'
        locale_edit = '{{ __("locale.edit") }}'
        locale_delete = '{{ __("locale.delete") }}'
        locale_add = '{{ __("locale.add") }}'
    />

@endsection