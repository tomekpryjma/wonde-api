@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Upcoming Classes') }}</div>
            </div>
        </div>
    </div>
    
    <upcoming-lessons
        employee-id="{{ $employeeId }}"
        api-url="{{ config('app.wonde.api_url') }}"
        school-id="{{ config('app.wonde.school_id') }}"
        token="{{ config('app.wonde.auth_token') }}"/>
</div>
@endsection
