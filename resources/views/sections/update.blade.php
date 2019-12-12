@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <section-edit-component :section-data="{{ $section }}" :section-users="{{ $sectionUsers }}" :users-data="{{ $users }}"></section-edit-component>
            </div>
        </div>
    </div>
@endsection
