@extends('layouts.master')
@section('content')
    {!! Form::model($video,[
        'method' => 'PUT',
        'id' => 'formSquadVideo',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.class_video.create_edit')
    {!! Form::close() !!}
@endsection
