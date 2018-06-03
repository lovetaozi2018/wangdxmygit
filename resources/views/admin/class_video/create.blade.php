@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formSquadVideo','data-parsley-validate' => 'true']) !!}
@include('admin.class_video.create_edit')
{!! Form::close() !!}
@endsection
