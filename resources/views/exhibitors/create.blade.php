@extends('app')

@section('content')

@include('exhibitors.form', ['view' => 'create'])

@endsection

@section('scripts')

<script src="/js/angular-min-1.3.15.js"></script>
<script src="/js/exhibitorApp.js"></script>

@endsection