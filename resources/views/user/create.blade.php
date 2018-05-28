@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formAdmin','data-parsley-validate' => 'true']) !!}
@include('user.create_edit')
{!! Form::close() !!}
@endsection
