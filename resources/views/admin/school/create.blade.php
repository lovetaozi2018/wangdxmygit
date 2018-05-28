@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formSchool','data-parsley-validate' => 'true']) !!}
@include('admin.school.create_edit')
{!! Form::close() !!}
@endsection
