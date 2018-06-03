@extends('layouts.master')
@section('content')
{!! Form::open(['method' => 'post','id' => 'formSchoolVideo','data-parsley-validate' => 'true']) !!}
@include('admin.school_video.create_edit')
{!! Form::close() !!}
@endsection
