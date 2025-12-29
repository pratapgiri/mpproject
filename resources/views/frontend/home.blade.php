@extends('frontend.layouts.master')

@section('title', 'Home')

@section('content')

<div class="row">

    {{-- LEFT SIDEBAR --}}
    <div class="col-md-3">
        {{--@include('frontend.sections.pubmed')
        @include('frontend.sections.reprint')
        @include('frontend.sections.recent-articles')--}}
    </div>

    {{-- CENTER CONTENT --}}
    <div class="col-md-6">
        {{--@include('frontend.sections.open-access')
        @include('frontend.sections.why-publish')--}}
    </div>

    {{-- RIGHT SIDEBAR --}}
    <div class="col-md-3">
        {{--@include('frontend.sections.journal-slider')
        @include('frontend.sections.editor-in-chief')--}}
    </div>

</div>

@endsection
