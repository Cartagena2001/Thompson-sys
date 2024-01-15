<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Email Send Using PHPMailer - webappfix.com</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
</head>

@extends('layouts.internal')

<body class="pt-8">
        
<div class="container mt-5" style="max-width: 750px">
    
    <h1>Email Send Using PHPMailer - webappfix.com</h1>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success  alert-dismissible">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    
    @if ($message = Session::get('error'))
        <div class="alert alert-danger  alert-dismissible">
            <strong>{{ $message }}</strong>
        </div>
    @endif
    
    <form method="post" action="{{ route('send.php.mailer.submit') }}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label>Recipient Email:</label>
            <input type="email" name="email" class="form-control" />
        </div>
        <div class="form-group">
            <label>Email Subject:</label>
            <input type="text" name="subject" class="form-control" />
        </div>
        <div class="form-group">
            <label>Email Body:</label>
            <textarea class="form-control" name="body"></textarea>
        </div>
        <div class="form-group">
          <div style="display: flex; justify-content: center;">

          </div>  
        </div>
        <div class="form-group mt-3 mb-3">
            <button type="submit" class="btn btn-success btn-block">Send Email</button>
        </div>
    </form>
</div>
</body>
</html>