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
    <div class="widewrapper main">
        <div class="container">
            <div class="row">
                <div class="col-md-8 blog-main">
                    <div class="row">


                        @foreach($res as $value)
                        <div class="col-md-6 col-sm-6">
                            <article class="blog-teaser">
                                <header>
                                    <img src="r_frontend/product/img/2.jpg" alt="">
                                    <h3><a href="productinfo?product_id={{$value['id']}}">{{$value['name']}}</a></h3>
                                    <span class="meta">{{$value['display_name']}}</span>
                                    <hr>
                                </header>
                                <div class="body">
                                   {{$value['content']}}
                                    </div>
                                <div class="clearfix">
                                    <a href="productinfo?product_id={{$value['id']}}" class="btn btn-clean-one">Read more</a>
                                </div>
                            </article>
                        </div>
                       @endforeach

                    </div>
                </div>

                <aside class="col-md-4 blog-aside">

                    <div class="aside-widget">
                        <header>
                            <h3>Featured Post</h3>
                        </header>
                        <div class="body">
                            <ul class="clean-list">
                                <li><a href="">Clean - Responsive HTML5 Template</a></li>
                                <li><a href="">Responsive Pricing Table</a></li>
                                <li><a href="">Yellow HTML5 Template</a></li>
                                <li><a href="">Blackor Responsive Theme</a></li>
                                <li><a href="">Portfolio Bootstrap Template</a></li>
                                <li><a href="">Clean Slider Template</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="aside-widget">
                        <header>
                            <h3>Related Post</h3>
                        </header>
                        <div class="body">
                            <ul class="clean-list">
                                <li><a href="">Blackor Responsive Theme</a></li>
                                <li><a href="">Portfolio Bootstrap Template</a></li>
                                <li><a href="">Clean Slider Template</a></li>
                                <li><a href="">Clean - Responsive HTML5 Template</a></li>
                                <li><a href="">Responsive Pricing Table</a></li>
                                <li><a href="">Yellow HTML5 Template</a></li>
                            </ul>
                        </div>
                    </div>

                    <div class="aside-widget">
                        <header>
                            <h3>Tags</h3>
                        </header>
                        <div class="body clearfix">
                            <ul class="tags">
                                <li><a href="#">HTML5</a></li>
                                <li><a href="#">CSS3</a></li>
                                <li><a href="#">COMPONENTS</a></li>
                                <li><a href="#">TEMPLATE</a></li>
                                <li><a href="#">PLUGIN</a></li>
                                <li><a href="#">BOOTSTRAP</a></li>
                                <li><a href="#">TUTORIAL</a></li>
                                <li><a href="#">UI/UX</a></li>
                            </ul>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
@stop
    

    

