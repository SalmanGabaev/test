@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <user-edit-component :user="{{ $user }}"></user-edit-component>
            </div>
        </div>
    </div>
@endsection
