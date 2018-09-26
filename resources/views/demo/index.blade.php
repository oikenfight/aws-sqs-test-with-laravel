{{-- layout --}}
@extends('layouts.default')

{{-- Additional Css --}}
@section('additionalCss')
@endsection

{{-- Additional JavaScript --}}
@section('additionalJs')
@endsection

{{-- titleSuffix --}}
@section('titleSuffix', 'demo')

{{-- Content --}}
@section('content')
    <div>
        <div id="demo-app">
            {{--<demo-app-component></demo-app-component>--}}
        </div>
    </div>
@endsection
