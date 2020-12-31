<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'ar') dir="rtl" @else dir="ltr"  @endif class="no-js">
	<head>
		<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        
		<!-- ==============================================
		TITLE AND META TAGS
		=============================================== -->
        @php
        $title = \App\settings::where('key','site_title')->first();
        @endphp
		<title>{{$title->value ?? ''}}</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{asset('assets/img/master/logo.png')}}" />

		<!-- ==============================================
		FAVICON
		=============================================== -->  
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap" rel="stylesheet">  
		<!-- ==============================================
		CSS
		=============================================== -->
        <meta name="csrf-token" content="{{csrf_token()}}">
        <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/navbar.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/stylesheet.css')}}">
        <link rel="stylesheet" href="{{asset('assets/fonts/font-awesome/css/font-awesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
        <script src="{{asset('assets/js/modernizr-custom.js')}}"></script>
        <script src="{{asset('js/moment.js')}}"></script>
        <script src="{{asset('js/moment-with-locales.min.js')}}"></script>
        <!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5f3fd09a1e7ade5df442d2ab/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
	</head>
    @if(Request::route()->getName() == 'index')
    <style>
        .section-header{
            height: 900px !important;
        }
    </style>
    @endif
<body class="{{ app()->getLocale() }}">
     <div  class="loadingio-spinner-rolling-bhl56zqj4fa hideloader main_sppiner"><div class="ldio-lm074eabdy">
<div></div>
</div></div>