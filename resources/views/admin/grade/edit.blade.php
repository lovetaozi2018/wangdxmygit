@extends('layouts.master')
@section('content')
    {!! Form::model($grade,[
        'method' => 'PUT',
        'id' => 'formGrade',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.grade.create_edit')
    {!! Form::close() !!}
@endsection
