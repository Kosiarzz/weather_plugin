@extends('app')

@section('content')
<div class="container">
    <div class="contentCenter">
        <div class="nav">
            <a class="btn-link" href="{{route('weather.index')}}">Pogoda</a>
            <a class="btn-link" href="{{route('city.settings')}}">Ustawienia</a>
        </div>
        <h3>Historia pogody</h3>
        @if(count($weather)==0)
            <div class="notData">
                BRAK DANYCH
            </div>
        @else
            @foreach($weather as $weather)
                <?php $data = json_decode(json_decode($weather->data, TRUE));?>
                <div class="rowHistory">
                    <div class="city">
                        {{$weather->name}}, {{$data->sys->country}}
                        <div class="time">
                            {{date("H:i", $data->dt)}}<br>
                            {{date("d.m.y", $data->dt)}}
                        </div>
                    </div>
                    <div class="cords">
                        {{$data->coord->lon}}, {{$data->coord->lat}}
                    </div>
                    <div class="info">
                        <div class="cloud">
                            <img src="{{ asset('img/'.$data->weather[0]->icon.'.png') }}" alt="cloud"><br>
                        </div>
                        <div class="tempInfo">
                            <div class="mainTemp">
                                {{number_format($data->main->temp,1,'.','')}} <sup>°</sup>C<br>
                            </div>
                            <div class="feelsLike">
                                Odczuwalna {{number_format($data->main->feels_like,1,'.','')}} <sup>°</sup>C
                            </div>
                        </div>
                    </div>
                    <div class="moreInfo">
                        {{ucfirst($data->weather[0]->description)}} <br><br>
                        Prędkość wiatru {{$data->wind->speed}} m/s 
                        <span id="wind_deg">
                            @if($data->wind->deg > 348)
                                (N)
                            @elseif($data->wind->deg > 326)
                                (NNW)
                            @elseif($data->wind->deg > 303)
                                (NW)
                            @elseif($data->wind->deg > 281)
                                (WNW)
                            @elseif($data->wind->deg > 258)
                                (W)
                            @elseif($data->wind->deg > 236)
                                (WSW)
                            @elseif($data->wind->deg > 213)
                                (SW)
                            @elseif($data->wind->deg > 191)
                                (SSW)
                            @elseif($data->wind->deg > 168)
                                (S)
                            @elseif($data->wind->deg > 146)
                                (SSE)
                            @elseif($data->wind->deg > 123)
                                (SE)
                            @elseif($data->wind->deg > 101)
                                (ESE)
                            @elseif($data->wind->deg > 78)
                                (E)
                            @elseif($data->wind->deg > 56)
                                (ENE)
                            @elseif($data->wind->deg > 33)
                                (NE)
                            @elseif($data->wind->deg > 11)
                                (NNE)
                            @else
                                (N)
                            @endif()
                        </span><br>

                        Wilgotność {{$data->main->humidity}} %<br>
                        Ciśnienie {{$data->main->pressure}} hPa<br>
                        Zachmurzenie {{$data->clouds->all}} %<br>
                        Widoczność {{number_format($data->visibility /1000,1,'.','')}} km<br>

                        Wschód słońca {{date("H:i:s", $data->sys->sunrise)}} <br> 
                        Zachód słońca {{date("H:i:s", $data->sys->sunset)}}   
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
@push('css')
    <link href="{{ asset('css/weather.css') }}" rel="stylesheet">
@endpush