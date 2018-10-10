@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <image-gallary :test_images="images" :selected_test="selected_test"></image-gallary>
        </div>
    </div>
</div>
@endsection
