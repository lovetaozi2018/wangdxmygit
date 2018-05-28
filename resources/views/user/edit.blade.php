@extends('layouts.master')
@section('content')
    {!! Form::model($admin,[
        'method' => 'PUT',
        'id' => 'formAdmin',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('user.create_edit')
    {!! Form::close() !!}
@endsection
