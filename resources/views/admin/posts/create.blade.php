@extends('admin.layouts.app')

@section('title', 'New Post')
@section('page-title', 'New Post')

@section('content')
    <form action="{{ route('admin.posts.store') }}" method="POST">
        @csrf
        @include('admin.posts._form', ['post' => null])
    </form>
@endsection
