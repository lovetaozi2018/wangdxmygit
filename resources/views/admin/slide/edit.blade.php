@extends('layouts.master')
@section('content')
    {!! Form::model($slide,[
        'method' => 'PUT',
        'id' => 'formSlide',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.slide.create_edit')
    {!! Form::close() !!}
@endsection
