@extends('frontend.layouts.app')

@section('main-content')
    <p align="center">
        <iframe id="telrPaymentFrame" name="telrPaymentFrame" src="{{ $url }}" width="1100" height="700" scrolling="yes" /></iframe>
    </p>
@endsection