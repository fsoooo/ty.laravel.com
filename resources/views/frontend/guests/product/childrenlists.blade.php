@extends('frontend.guests.layout.base')
@section('content')
    <section class="team" id="team">
        <div class="container">

        </div>
    </section>
    <section class="team" id="team">
        <div class="container">

        </div>
    </section>
    <section class="team" id="team">
        <div class="container">

        </div>
    </section>
    <section class="team" id="team">
        <div class="container">
            <div class="row">
                <div class="team-heading text-center">

                    <section class="team" id="team">
                        <div class="container">

                        </div>
                    </section>
                    </div>
                @foreach($res as $value)
                <div class="col-md-2 single-member col-sm-4">
                    <div class="person">
                        <img class="img-responsive" src="r_frontend/img/member1.jpg" alt="member-1">
                    </div>
                    <a href="childlists?label_id={{$value['id']}}">
                    <div class="person-detail">
                        <div class="arrow-bottom"></div>
                        <h3>{{$value['name']}}</h3>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, </p>
                    </div>
                    </a>
                </div>
                @endforeach




            </div>
        </div>
    </section><!-- end of team section -->

@stop