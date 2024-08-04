@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        Posts Overview
                    </div>
                    <div class="card-body">
                        <a href="{{route('post.create')}}" class="btn btn-success mb-3 ms-3">Create a Post</a>
                        @include('post.posts')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
