@extends('app')

@section('content')
<div class="container">
    <div class="contentCenter">
        <div class="nav">
            <a class="btn-link" href="{{route('weather.index')}}">Pogoda</a>
            <a class="btn-link" href="{{route('city.settings')}}">Ustawienia</a>
        </div>

        <!-- Current weather section-->
        <h3>Aktualna prognoza pogody</h3>
        <div class="weatherNow">
            <div class="row">
                <div class="city">
                {{$city}},{{$country}}
                </div>
                <div class="cords">
                    {{$weather->lon}}, {{$weather->lat}}
                </div>
                <div class="info">
                    <div class="cloud">
                        <img src="{{ asset('img/'.$weather->current->weather[0]->icon.'.png') }}" alt="cloud"><br>
                    </div>
                    <div class="tempInfo">
                        <div class="mainTemp">
                            {{number_format($weather->current->temp,1,'.','')}} <sup>°</sup>C<br>
                        </div>
                        <div class="feelsLike">
                            Odczuwalna {{number_format($weather->current->feels_like,1,'.','')}} <sup>°</sup>C
                        </div>
                    </div>
                </div>
                <div class="moreInfo">
                    {{ucfirst($weather->current->weather[0]->description)}}  <br><br>
                    Prędkość wiatru {{$weather->current->wind_speed}} m/s
                    <span id="wind_deg">
                        @if($weather->current->wind_deg > 348)
                            (N)
                        @elseif($weather->current->wind_deg > 326)
                            (NNW)
                        @elseif($weather->current->wind_deg > 303)
                            (NW)
                        @elseif($weather->current->wind_deg > 281)
                            (WNW)
                        @elseif($weather->current->wind_deg > 258)
                            (W)
                        @elseif($weather->current->wind_deg > 236)
                            (WSW)
                        @elseif($weather->current->wind_deg > 213)
                            (SW)
                        @elseif($weather->current->wind_deg > 191)
                            (SSW)
                        @elseif($weather->current->wind_deg > 168)
                            (S)
                        @elseif($weather->current->wind_deg > 146)
                            (SSE)
                        @elseif($weather->current->wind_deg > 123)
                            (SE)
                        @elseif($weather->current->wind_deg > 101)
                            (ESE)
                        @elseif($weather->current->wind_deg > 78)
                            (E)
                        @elseif($weather->current->wind_deg > 56)
                            (ENE)
                        @elseif($weather->current->wind_deg > 33)
                            (NE)
                        @elseif($weather->current->wind_deg > 11)
                            (NNE)
                        @else
                            (N)
                        @endif()
                    </span><br>

                    Wilgotność {{$weather->current->humidity}} %<br>
                    Ciśnienie {{$weather->current->pressure}} hPa<br>
                    Zachmurzenie {{$weather->current->clouds}} %<br>
                    Widoczność {{number_format($weather->current->visibility /1000,1,'.','')}} km<br>

                    Wschód słońca {{date("H:i:s", $weather->current->sunrise+$weather->timezone_offset)}} <br> 
                    Zachód słońca {{date("H:i:s", $weather->current->sunset+$weather->timezone_offset)}}   
                </div>
            </div>
        </div>

        <!-- Hourly weather section-->
        <div class="hourlySection">
            <h3>Pogoda godzinowa</h3>

            @foreach($weather->hourly as $hourly)
                <div class="rowHourly">
                    <div class="hourlyDate">{{date("H:i", $hourly->dt+$weather->timezone_offset)}}</div>
                    <div class="cloudHourly">
                        <img src="{{ asset('img/'.$hourly->weather[0]->icon.'.png') }}" alt="cloud"><br>
                    </div>
                    <div class="hourlyMoreInfo">
                        <div class="hourlyTemp">{{number_format($hourly->temp,1,'.','')}} <sup>°</sup>C<br></div>
                        {{$hourly->wind_speed}} m/s<br>
                        {{$hourly->pressure}} hPa
                    </div>
                    <div class="hourlyClouds">Zachmurzenie {{$hourly->clouds}}%</div>
                </div>
            @endforeach
        </div>

        <!-- Daily weather section-->
        <div class="daysSection">
            <h3>Pogoda kilkudniowa</h3>

            @foreach($weather->daily as $daily)
                <div class="rowDaily">
                    <div class="dailyDate">
                        {{date("d.m.y", $daily->sunrise+$weather->timezone_offset)}}
                    </div>
                    <div class="cloudDaily">
                        <img src="{{ asset('img/'.$daily->weather[0]->icon.'.png') }}" alt="cloud"><br>
                    </div>
                    <div class="dayDescription">
                        {{ucfirst($daily->weather[0]->description)}}
                    </div>
                    <div class="tempDaily">
                        <img src="{{ asset('img/01d.png') }}" alt="day"><span class="temperatureDaily">{{$daily->temp->day}}<sup>°</sup>C </span>&nbsp;&nbsp;
                        <img src="{{ asset('img/01n.png') }}" alt="night"><span class="temperatureDaily">{{$daily->temp->night}}<sup>°</sup>C</span><br>
                    </div>
                    {{$daily->wind_speed}} m/s &nbsp;&nbsp;
                    Wilgotność {{$daily->humidity}} % <br>
                    {{$daily->pressure}} hPa &nbsp;&nbsp;
                    Zachmurzenie {{$daily->clouds}} %
                </div>
            @endforeach
        </div>

        <!-- History weather section-->
        <div class="historySection">
            <h3>Historia pogody</h3>
            
            @if(is_null($weatherHistory))
                Brak historii pogody dla tej miejscowości.
            @else
                Najstarszy zapis pogody dla tej miejscowości pochodzi z <b>{{$weatherHistory->created_at}}</b><br><br>
                
                <form method="post" action="{{ route('weather.showHistory') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="city" value="{{$city}}">
                    Podaj zakres czasu<br>
                    Od
                    <input type="date" name="dateFrom">
                    <input type="time" name="timeFrom"><br>
                    Do
                    <input type="date" name="dateTo">
                    <input type="time" name="timeTo"><br>
                    <button type="submit">Sprawdź pogodę</button>
                </form>
            @endif
        </div>


    </div>
</div>
@endsection
@push('css')
    <link href="{{ asset('css/weatherDetails.css') }}" rel="stylesheet">
@endpush