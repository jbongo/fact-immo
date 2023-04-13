<!doctype html>
<html lang="fr">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>Facturation</title>
      <link href="{{public_path('css/lib/bootstrap-pdf.css')}}" rel="stylesheet">
      <link href="{{public_path('css/style_pdf.css')}}" rel="stylesheet">
      <style>
         .pad-top-botm {
         padding-bottom:40px;
         padding-top:15px;
         }
         .contact-info span {
         font-size:14px;
         padding:0px 50px 0px 50px;
         }
         .contact-info hr {
         margin-top: 0px;
         margin-bottom: 0px;
         }
         .client-info {
         font-size:15px;
         }
         .ttl-amts {
         text-align:right;
         padding-right:50px;
         }
      </style>
   </head>
   <body>
      @yield('content')
   </body>