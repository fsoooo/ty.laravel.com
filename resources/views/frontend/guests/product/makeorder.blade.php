@extends('frontend.guests.layout.base')
@section('content')
    <!-- contact section starts here -->
    <section class="team" id="team">
        <div class="container">

        </div>
    </section>
    <!-- map section -->
    <div class="api-map" id="contact">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 map" id="map"></div>
            </div>
        </div>
    </div>
    <!-- contact section starts here -->
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="contact-caption clearfix">
                     <div class="contact-heading text-left">
                        <h4>&nbsp;</h4>
                         <font color="white">   为谁投保：</font>
                        <select name="family" >
                            <option>父亲</option>
                            <option>母亲</option>
                            <option>妻子</option>
                            <option>儿子</option>
                            <option>女儿</option>
                        </select><br/><br/>
                         <font color="white">   起保日期：</font>
                        <input class="email" type="email" placeholder="日历插件">
                       </div>
                    <div class="col-md-5 contact-info text-left">

                        <h3>投保人信息</h3>
                        <div class="info-detail">

                            <ul><li><i class="fa fa-calendar"></i><span>Name:</span>  <input type="text" name="policy"></li></ul>
                            <ul><li><i class="fa fa-map-marker"></i><span>Addr:</span> &nbsp;  <input type="text" name="policy"></li></ul>
                            <ul><li><i class="fa fa-phone"></i><span>Phone:</span><input type="text" name="policy"></li></ul>
                            <ul><li><i class="fa fa-fax"></i><span>IDcard:</span><input type="text" name="policy"></li></ul>
                            <ul><li><i class="fa fa-envelope"></i><span>Email:</span>&nbsp;<input type="text" name="policy"></li></ul>
                            <ul><li><i class="fa fa-envelope"></i><span>Email:</span>&nbsp;<input type="text" name="policy"></li></ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-md-offset-1 contact-form">
                        <h3>被保人信息</h3>
                        <form class="form">
                            <input class="name" type="text" placeholder="Name">
                            <input class="email" type="email" placeholder="Email">
                            <input class="phone" type="text" placeholder="Phone No:">
                            <input class="phone" type="text" placeholder="Phone No:">
                            <textarea class="message" name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                        </form>

                    </div>
                    <div class="contact-caption clearfix">
                        <div class="contact-heading text-center">
                            <h2><a onclick="doSubmit()">Submit</a></h2>
                        </div>
                </div>

            </div>

        </div>
    </section><!-- end of contact section -->
    <script>
        function  doSubmit() {
                alert('提交订单');
        }
    </script>
@stop