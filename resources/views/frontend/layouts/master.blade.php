<!DOCTYPE html>
<html lang="zxx">
<head>
	
	@include('frontend.layouts.head')	
</head>
<body class="js">
	
	<!-- End Preloader -->
	
	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')
	
	@include('frontend.layouts.footer')

</body>
</html>