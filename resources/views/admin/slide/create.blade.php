@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formSlide','data-parsley-validate' => 'true']) !!}
@include('admin.slide.create_edit')
{!! Form::close() !!}
@endsection
