@extends('app')

@section('content')
<div class="container">
    <div class="contentCenter">
        <div class="nav">
            <a class="btn-link" href="{{route('city.settings')}}">Ustawienia</a>
        </div>
        @foreach($weather as $weather)
            <a href="{{route('weather.show', ['lat' => $weather->coord->lat, 'lon' => $weather->coord->lon, 'city' => $weather->name, 'country' => $weather->sys->country])}}">
                <div class="row">
                    <div class="city">
                    {{$weather->name}}, {{$weather->sys->country}}
                    </div>
                    <div class="cords">
                        {{$weather->coord->lon}}, {{$weather->coord->lat}}
                    </div>
                    <div class="info">
                        <div class="cloud">
                            <img src="{{ asset('img/'.$weather->weather[0]->icon.'.png') }}" alt="cloud"><br>
                        </div>
                        <div class="tempInfo">
                            <div class="mainTemp">
                                {{number_format($weather->main->temp,1,'.','')}} <sup>°</sup>C<br>
                            </div>
                            <div class="feelsLike">
                                Odczuwalna {{number_format($weather->main->feels_like,1,'.','')}} <sup>°</sup>C
                            </div>
                        </div>
                    </div>
                    <div class="moreInfo">
                        {{ucfirst($weather->weather[0]->description)}} <br><br>
                        Prędkość wiatru {{$weather->wind->speed}} m/s 
                        <span id="wind_deg">
                            @if($weather->wind->deg > 348)
                                (N)
                            @elseif($weather->wind->deg > 326)
                                (NNW)
                            @elseif($weather->wind->deg > 303)
                                (NW)
                            @elseif($weather->wind->deg > 281)
                                (WNW)
                            @elseif($weather->wind->deg > 258)
                                (W)
                            @elseif($weather->wind->deg > 236)
                                (WSW)
                            @elseif($weather->wind->deg > 213)
                                (SW)
                            @elseif($weather->wind->deg > 191)
                                (SSW)
                            @elseif($weather->wind->deg > 168)
                                (S)
                            @elseif($weather->wind->deg > 146)
                                (SSE)
                            @elseif($weather->wind->deg > 123)
                                (SE)
                            @elseif($weather->wind->deg > 101)
                                (ESE)
                            @elseif($weather->wind->deg > 78)
                                (E)
                            @elseif($weather->wind->deg > 56)
                                (ENE)
                            @elseif($weather->wind->deg > 33)
                                (NE)
                            @elseif($weather->wind->deg > 11)
                                (NNE)
                            @else
                                (N)
                            @endif()
                        </span><br>

                        Wilgotność {{$weather->main->humidity}} %<br>
                        Ciśnienie {{$weather->main->pressure}} hPa<br>
                        Zachmurzenie {{$weather->clouds->all}} %<br>
                        Widoczność {{number_format($weather->visibility /1000,1,'.','')}} km<br>

                        Wschód słońca {{date("H:i:s", $weather->sys->sunrise+$weather->timezone)}} <br> 
                        Zachód słońca {{date("H:i:s", $weather->sys->sunset+$weather->timezone)}}   
                    </div>
                    <div class="details">
                        <i>Kliknij aby zobaczyć więcej informacji</i>
                    </div> 
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
@push('css')
    <link href="{{ asset('css/weather.css') }}" rel="stylesheet">
@endpush