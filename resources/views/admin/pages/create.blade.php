@extends('admin.layouts.app')
@section('title', 'New Page')
@section('page-title', 'New Page')
@section('content')
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        @include('admin.pages._form', ['page' => null])
    </form>
@endsection
