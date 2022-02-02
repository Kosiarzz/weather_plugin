@extends('app')

@section('content')
    <div class="container">
        <div class="contentCenter">
            <div class="nav">
                <a class="btn-link" href="{{route('weather.index')}}">Pogoda</a>
            </div>
            <form method="POST" action="{{ route('city.store') }}" enctype="multipart/form-data">
                @csrf
                <input name="name" min="1" maxlength="50" autocomplete="name" autofocus required><br>

                <button class="saveCityButton" type="submit">
                    Zapisz miejscowość
                </button>
            </form>
            <div id="alerts">
                @error('name') 
                    <div class="alertDanger">
                        {{ $message }}
                    </div>
                @enderror
                @if (session('Success'))
                    <div class="alertSuccess">
                        {{ session('Success') }}
                    </div>
                @endif

                @if (session('Danger'))
                    <div class="alertDanger">
                        {{ session('Danger') }}
                    </div>
                @endif
            </div>

            <h2>Miejscowości których dane pogodowe są zapisywane ({{count($saveCities)}}/10)</h2>

            @foreach($saveCities as $city)
                <div class="row">
                    <div class="cityName">
                        {{$city->name}}
                    </div>
                    <div class="controls">
                        <button class="deleteBtn" data-id="{{$city->id}}">Usuń</button>
                        <form class="form" method="POST" action="{{ route('city.notSaveWeatherData') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$city->id}}">
                            <button class="notSave" type="submit">
                                Przestań zapisywać
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach

            <h2>Dodane miejscowości</h2>

            @foreach($cities as $city)
                <div class="row">
                    <div class="cityName">
                        {{$city->name}}
                    </div>
                    <div class="controls">
                        <button class="deleteBtn" data-id="{{$city->id}}">Usuń</button>
                        <form class="form" method="POST" action="{{ route('city.saveWeatherData') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{$city->id}}">
                            <button class="addBtn" type="submit">
                                Zapisuj dane
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
@section('javascript')
    const deleteUrl = "{{url('settings')}}/city/";
@endsection
@section('js-files')
    <script src="{{ asset('js/delete.js') }}"></script>
@endsection
@push('css')
    <link href="{{ asset('css/settings.css') }}" rel="stylesheet">
@endpush