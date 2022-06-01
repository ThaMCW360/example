@extends('layouts.app')

@section('content')
    <title></title>
</head>
<body>

@include('layouts.header')
<div class="row">
    <div class="col-lg-2 text-center">
    </div>
    <div class="col-lg-6">
        <div class="ad-item row">
            <div class="col-lg-3"><img src="/assets/images/{{$advertising->id}}.png" onerror="if (this.src != '/assets/images/no-image.png') this.src = '/assets/images/no-image.png';"></div>
            <div class="col-lg-9"><h1>{{$advertising->title}}</h1>
            <p>{{$advertising->value}}</p></div>
            <div class="col-lg-3"></div>
            <div class="col-lg-9"></div>

        </div>
        <div class="row">
            <form method="GET" action="/appointment/{{$advertiser_id}}/{{$advertising->id}}/new" id="newAppointment">
                @csrf
                <p>Date: <input type="text" id="datepicker" size="30" name="date"></p>
                <p><select class="timepicker" name="time"></select></p>
                <input type="hidden" name="advertising_id" value="{{$advertising->id}}">
                <input type="hidden" name="advertiser_id" value="{{$advertiser_id}}">
                <input type="submit" name="" value="Rezerwuj">
            </form>
        </div>
    </div>
    <div class="col-lg-4"></div>

</div>
@endsection
