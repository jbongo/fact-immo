<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Fact-immo</title>

    <!-- Styles -->
    <link href="{{ asset('css/lib/chartist/chartist.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/themify-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/owl.carousel.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/lib/owl.theme.default.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/lib/weather-icons.css')}}" rel="stylesheet" />
    <link href="{{ asset('css/lib/menubar/sidebar.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/unix.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('css/dropzone.css')}}" rel="stylesheet">
    <link href="{{ asset('css/dropzone-custom.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/sweetalert/sweetalert.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/data-table/data-table.css')}}" rel="stylesheet">
    <link href="{{ asset('css/lib/select2/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/lib/bootstrap-select.min.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<style>
    fieldset 
	{
		border: 1px solid #ddd !important;
		margin: 0;
		xmin-width: 0;
		padding: 10px;       
		position: relative;
		border-radius:4px;
		background-color:#f5f5f5;
		padding-left:10px!important;
	}	
	
		legend
		{
			font-size:14px;
			font-weight:bold;
			margin-bottom: 0px; 
			width: 35%; 
			border: 1px solid #ddd;
			border-radius: 4px; 
			padding: 5px 5px 5px 10px; 
			background-color: #ffffff;
    }
</style>