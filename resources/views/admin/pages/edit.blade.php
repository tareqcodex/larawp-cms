@extends('admin.layouts.app')
@section('title', 'Edit Page')
@section('page-title', 'Edit Page')
@section('content')
    <form action="{{ route('admin.pages.update', $page) }}" method="POST">
        @csrf
        @method('PUT')
        @include('admin.pages._form', ['page' => $page])
    </form>
@endsection
