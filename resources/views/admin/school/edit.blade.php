@extends('layouts.master')
@section('content')
    {!! Form::model($school,[
        'method' => 'PUT',
        'id' => 'formSchool',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.school.create_edit')
    {!! Form::close() !!}
@endsection
