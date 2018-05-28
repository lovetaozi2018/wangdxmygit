@extends('layouts.master')
@section('content')
    {!! Form::model($classes,[
        'method' => 'PUT',
        'id' => 'formSquad',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.class.create_edit')
    {!! Form::close() !!}
@endsection
