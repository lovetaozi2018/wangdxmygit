@extends('layouts.master')
@section('content')
    {!! Form::model($picture,[
        'method' => 'PUT',
        'id' => 'formPicture',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.picture.create_edit')
    {!! Form::close() !!}
@endsection
