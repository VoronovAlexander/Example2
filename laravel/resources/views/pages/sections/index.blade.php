@extends('layouts.app')

@section('content')

    <sections-table-component
        locale_users = '{{ __("locale.users") }}'
        locale_sections = '{{ __("locale.sections") }}'
        locale_edit = '{{ __("locale.edit") }}'
        locale_delete = '{{ __("locale.delete") }}'
        locale_add = '{{ __("locale.add") }}'
    />

@endsection