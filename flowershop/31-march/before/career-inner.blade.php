@extends('frontend.layouts.app')

@section('main-content')

<!-- careers section -->
<section class="career-inner common-spacing">
    <article class="container">
        <h1 class="mb-3">{{ $career->getTitle() }}</h1>
        {!! $career->getDescription() !!}
        <form>
            <button type="submit" class="btn-outline">Apply for this role</button>
        </form>
    </article>
</section>
@endsection