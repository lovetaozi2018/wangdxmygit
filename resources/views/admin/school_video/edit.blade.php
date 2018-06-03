@extends('layouts.master')
@section('content')
    {!! Form::model($schoolVideo,[
        'method' => 'PUT',
        'id' => 'formSchoolVideo',
        'data-parsley-validate' => 'true'
    ]) !!}
    @include('admin.school_video.create_edit')
    {!! Form::close() !!}
@endsection
