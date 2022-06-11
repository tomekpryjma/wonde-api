@extends('layouts.app')

@section('content')
    <upcoming-lessons
        employee-id="{{ $employeeId }}"
        api-url="{{ config('app.wonde.api_url') }}"
        school-id="{{ config('app.wonde.school_id') }}"
        token="{{ config('app.wonde.auth_token') }}"/>
@endsection
