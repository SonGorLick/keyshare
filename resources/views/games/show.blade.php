@extends('layouts.app')

@section('header')
    {{ $game->name }}
@endsection

@section('content')
<div class="container">
    <b-card style="background-color: #e9ecef;">
        <b-container fluid>
            <b-row>
                <b-col>
                    <img src="{{ asset($game->image) }}" class="img-fluid mx-auto d-block rounded">
                    <!-- <span>{{$game->name}}</span> -->
                    @if($genres)
                        <br>
                        @foreach($genres as $genre)
                        <span class="badge bg-secondary">{{$genre->name}}</span>
                        @endforeach
                    @endif
                </b-col>
                @if($screenshots) 
                    <b-col cols="9" sm="9">
                        <b-carousel
                            id="carousel-1"
                            v-model="slide"
                            :interval="4000"
                            controls
                            indicators
                            background="#ababab"
                            img-width="940"
                            img-height="529"
                            style="text-shadow: 1px 1px 2px #333; margin-bottom: 10px;"
                            >
                                @foreach($screenshots as $screenshot)
                                    <b-carousel-slide
                                        img-src="https://images.igdb.com/igdb/image/upload/t_screenshot_big/{{$screenshot->image_id}}.jpg"
                                    ></b-carousel-slide>
                                @endforeach
                        </b-carousel>
                    </b-col>
                @endif
            </b-row>
        </b-container>
        @if($igdb && $igdb->aggregated_rating)
            <template #footer>
                <b-form-rating id="rating-inline" inline value="{{ $igdb->aggregated_rating / 20 }}" disabled></b-form-rating>
                <label for="rating-inline">By {{ $igdb->aggregated_rating_count }} reviewers</label>
            </template>
        @endif
    </b-card>
    <br>
    @can('admin',Auth::user())
        <a href="{{ route('editgame', ['id' => $game->id]) }}">{{ __('games.editgame') }}</a><br>
    @endcan
    <p> {{$game->description}} </p>

    <table class="table">

        @if(count($keys) > 0)
            <tr>
                <th>{{ __('games.platform') }}</th>
                <th>{{ __('games.addedby') }}</th>
            </tr>
            @foreach($keys as $key)
                <tr>
                <td>
                    <a href="/keys/{{$key->id}}">{{$key->platform->name}}</a>
                </td>
                    <td>
                        <a href="/users/{{$key->createduser->id}}">
                            {{$key->createduser->name}}
                        </a>
                    <span class="badge badge-pill {{ $key->createduser->karma_color }}"> {{ $key->createduser->karma }} </span>
                    </td>
                <tr>
            @endforeach
        @else
            <p> {{ __('games.nokeys') }} <p>
        @endif
    </table>

    @if ($dlcCount > 0)
        <div class="page">
            <title-header title="DLC"></title-header>
            <Game-List url="{{ $dlcurl }}"></Game-List>
        </div>
    @endif
</div>
@endsection
