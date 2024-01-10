@extends('frontend.layouts.app')

@section('main-content')
<section class="common-spacing">
    <article class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="page-title">
                    <div id="page-terms" class="active">
                        <h1 class="mb-3">Privacy Policy</h1>
                        <p>These terms and conditions (the "Terms and Conditions") are the terms and conditions upon which Maison Des Fleurs
                            ("we/us") make this website <a href="www.maisondesfleurs.com">www.maisondesfleurs.com</a> (the "Maison Des Fleurs
                            Service") available to you and any of our
                            services which are accessible on or via the <a href="www.maisondesfleurs.com">www.maisondesfleurs.com</a> site (the
                            "Maison Des Fleurs Service").
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link" href="{{ route('faqs') }}">FAQ</a>
                            <a class="nav-link" href="{{ route('term-conditions') }}">Terms & Conditions</a>
                            <a class="nav-link active" href="{{ route('privacy-policy') }}" >Privacy Policy</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content" id="v-pills-tabContent">
                            <div class="tab-pane fade show active" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
                                <div class="accordion" id="privacy">
                                @if($privacies != null && $privacies != '[]')   
                                    @foreach($privacies as $privacy)
                                    <div class="card {{ $loop->first ? 'active' : '' }}">
                                        <div class="card-header" id="heading-{{ $privacy->id }}">
                                            <h4>
                                                <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse-{{ $privacy->id }}"
                                                    aria-expanded="true" aria-controls="collapse-{{ $privacy->id }}">
                                                    {{ $privacy->getTitle() }}
                                                </button>
                                            </h4>
                                        </div>
                                
                                        <div id="collapse-{{ $privacy->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" aria-labelledby="heading-{{ $privacy->id }}" data-parent="#privacy">
                                            <div class="card-body">
                                                <p>{!! $privacy->getDetails() !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
</section>  
@endsection('main-content')

@push('top-css')
@endpush

@push('extra-js')

 <script>
        $(document).ready(function () {
            // faq 
            $('.nav-pills .nav-link').click(function(){
                var open = $(this).attr('data-open');
                $('.page-title > div').each(function(){
                    if (open == $(this).attr('id')) {
                        $('.page-title > div').removeClass('active');
                        $(this).addClass('active');
                    }
                });
            });
            $('.accordion .card-header .btn.btn-link').click(function(){
                var thisParent = $(this).parents('.card');
                 if (thisParent.hasClass('active')) {
                    $(this).parents('.card').removeClass('active');
                } else {
                    $('.accordion .card').removeClass('active');
                    $(this).parents('.card').addClass('active');
                }
            })
        });
    </script>
@endpush