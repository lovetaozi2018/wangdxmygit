@extends('layouts.master')
@section('content')
    {!! Form::model($student,[
        'method' => 'PUT',
        'id' => 'formStudent',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.student.create_edit')
    {!! Form::close() !!}
@endsection
