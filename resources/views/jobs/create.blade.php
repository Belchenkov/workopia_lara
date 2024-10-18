@extends('layout')

@section('title', 'Create Job')

@section('content')
    <h1>Create New Job</h1>
    <form action="/jobs" method="POST">
        @csrf
        <input
            type="text"
            name="title"
            placeholder="Please enter title"
        />
        <input
            type="text"
            name="description"
            placeholder="Please enter description"
        />
        <button type="submit">Submit</button>
    </form>
@endsection
