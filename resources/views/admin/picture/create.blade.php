@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formPicture','data-parsley-validate' => 'true']) !!}
@include('admin.picture.create_edit')
{!! Form::close() !!}
@endsection
