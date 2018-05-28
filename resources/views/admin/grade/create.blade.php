@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formGrade','data-parsley-validate' => 'true']) !!}
@include('admin.grade.create_edit')
{!! Form::close() !!}
@endsection
