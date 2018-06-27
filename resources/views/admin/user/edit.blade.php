@extends('layouts.master')
@section('content')
    {!! Form::model($user,[
        'method' => 'PUT',
        'id' => 'formUser',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.user.create_edit')
    {!! Form::close() !!}
@endsection
