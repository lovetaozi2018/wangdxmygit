@extends('layouts.master')
@section('content')
    {!! Form::model($teacher,[
        'method' => 'PUT',
        'id' => 'formTeacher',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.teacher.create_edit')
    {!! Form::close() !!}
@endsection
