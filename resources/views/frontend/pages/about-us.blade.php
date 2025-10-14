@extends('frontend.layouts.master')

@section('title','ADA || Biz barada')

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="index1.html">Baş sahypa<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="blog-single.html">Biz barada</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us section">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 col-12">
						<div class="about-content">
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<h3>Hoş geldiňiz!<span>ADA size garaşýar</span></h3>
							<p>@foreach($settings as $data) {{$data->description}} @endforeach</p>
							<div class="button">
								
								<a href="{{route('contact')}}" class="btn primary">Habarlaşmak üçin</a>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-12">
						<div class="about-img overlay">
							{{-- <div class="button">
								<a href="https://www.youtube.com/watch?v=nh2aYrGMrIE" class="video video-popup mfp-iframe"><i class="fa fa-play"></i></a>
							</div> --}}
							<img src="{{ asset('storage/photos/1/logo1.jpg	') }}" alt="ADA logo">


						</div>
					</div>
				</div>
			</div>
	</section>
	<!-- End About Us -->


<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Mugt eltip bermek</h4>
                    <p>100-den gowrak sargyt</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Mugt gaýdyp gelmek</h4>
                    <p>30 günüň içinde gaýdyp gelýär</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Howpsuz töleg</h4>
                    <p>100% ygtybarly töleg</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Iň oňat baha</h4>
                    <p>Kepillendirilen baha</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

	@include('frontend.layouts.newsletter')
@endsection
