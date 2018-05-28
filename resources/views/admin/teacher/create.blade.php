@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formTeacher','data-parsley-validate' => 'true']) !!}
@include('admin.teacher.create_edit')
{!! Form::close() !!}
@endsection
