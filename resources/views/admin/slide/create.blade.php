@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formSquad','data-parsley-validate' => 'true']) !!}
@include('admin.class.create_edit')
{!! Form::close() !!}
@endsection
