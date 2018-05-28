@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formStudent','data-parsley-validate' => 'true']) !!}
@include('admin.student.create_edit')
{!! Form::close() !!}
@endsection
