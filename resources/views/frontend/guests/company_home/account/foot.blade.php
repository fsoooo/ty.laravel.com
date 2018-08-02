<div class="footer-top">
    <ul class="clearfix">
        <li class="footer-list1">
            <div class="footer-img">
                <img src="{{config('view_url.person_url').'image/line.png'}}" alt="" />
            </div>
            <h4 class="footer-title">友情链接</h4>
            <ul class="footer-list clearfix">
                <li>
                    <a href="#">聚米网</a>
                </li>
                <li>
                    <a href="#">腾讯保险</a>
                </li>
                <li>
                    <a href="#">券妈妈</a>
                </li>
                <li>
                    <a href="#">火车票</a>
                </li>
                <li>
                    <a href="#">聚米网</a>
                </li>
                <li>
                    <a href="#">腾讯保险</a>
                </li>
                <li>
                    <a href="#">券妈妈</a>
                </li>
                <li>
                    <a href="#">火车票</a>
                </li>
            </ul>
        </li>
        <li class="footer-list2">
            <div class="footer-img">
                <img src="{{config('view_url.person_url').'image/about.png'}}" alt="" />
            </div>
            <h4 class="footer-title">关于我们</h4>
            <ul class="footer-list clearfix">
                <li>
                    <a href="#">公司介绍</a>
                </li>
                <li>
                    <a href="#">公告和新闻</a>
                </li>
                <li>
                    <a href="#">平台招聘</a>
                </li>
            </ul>
            <div class="footer-tel">8964-489-789</div>
            <div>24小时客服电话</div>
        </li>
        <li class="footer-list3">
            <div class="footer-img">
                <img src="{{config('view_url.person_url').'image/helper.png'}}" alt="" />
            </div>
            <h4 class="footer-title">帮助中心</h4>
            <ul class="footer-list clearfix">
                <li>
                    <a href="#">支付相关</a>
                </li>
                <li>
                    <a href="#">保单寄送相关</a>
                </li>
                <li>
                    <a href="#">退保相关</a>
                </li>
                <li>
                    <a href="#">理赔相关</a>
                </li>
            </ul>
        </li>
        <li class="footer-list4">
            <div class="footer-img">
                <img src="{{config('view_url.person_url').'image/else.png'}}" alt="" />
            </div>
            <h4 class="footer-title">其他</h4>
            <ul class="footer-list clearfix">
                <li>
                    <a href="#">网站资质</a>
                </li>
                <li>
                    <a href="#">网站证书</a>
                </li>
                <li>
                    <a href="#">移动版下载</a>
                </li>
            </ul>
            <div class="footer-download clearfix">
                <div class="footer-download-img fl">
                    <img src="{{config('view_url.person_url').'image/微信图片_20170803113628.png'}}" alt="" />
                </div>
                <div class="footer-download-content fl">
                    <p>扫码下载客户端</p>
                    <p>立即领取保险</p>
                </div>
            </div>
        </li>
    </ul>
</div>
<div class="footer-bottom">
    <div>
        <span>保险营业许可：26595456135684</span>
        <span>备案号：京ICP备45894532号</span>
        <span>公安网络备案：45689715469871号</span>
    </div>
    <div>Copyright2017-2018</div>
</div>
<script src="{{config('view_url.company_url').'js/lib/jquery-1.11.3.min.js'}}"></script>
<script src="{{config('view_url.company_url').'js/lib/area.js'}}"></script>
<script src="{{config('view_url.company_url').'js/lib/profession.js'}}"></script>
<script src="{{config('view_url.company_url').'js/common.js'}}"></script>
<script>
    var upload = function(e){
        var _this = $(e);
        console.log(_this);
        var max_size=2097152;
        var $c = _this.parent().find('input[type=file]')[0];
        var file = $c.files[0],reader = new FileReader();
        if(!/\/(png|jpg|PNG|JPG|jpeg|JPEG)$/.test(file.type)){
            Mask.alert('图片支持jpg,png,jpeg格式',2);
            return false;
        }
        if(file.size>max_size){
            Mask.alert('单个文件大小必须小于等于2MB',2)
            return false;
        }

        reader.readAsDataURL(file);
        reader.onload = function(e){
            var html = '<img src="'+ e.target.result +'" />'
            _this.parent().find('.upload-wrapper').html(html);
            $('.company-img-tips.yellow').html('上传成功');
            $('.btn-upload').text('重新上传');
            _this.parent().find('.inputhidden').val(e.target.result);
        };
    };
    $(function() {
        new Cascade($('#province'),$('#city'),$('#county'));
        $('.btn-upload').click(function(){
            $(this).parent().find('input').click();
        });
        $('.btn-select').click(function() {
            $('.form-wrapper .error').html('');
            $(this).addClass('active').siblings().removeClass('active');
            var index = $(this).index();
            var $input = $(this).parents('li').find('input');
            $input.prop('checked',false).eq(index).prop('checked',true);
            index === 0 ? $('.hide').hide() : $('.hide').show();
        })

        $('.btn-save').click(function(){
            $('.form-wrapper .error').html('');

            checkCorrect($('#tel'),telReg);
            checkCorrect($('#email'),emailReg);

            var mustArry = $('.form-wrapper input');
            mustArry.each(function(){
                checkEmpty(this);
            });
            var selectArry = $('.form-wrapper select');
            selectArry.each(function(){
                checkEmpty(this);
            });
            checkEmpty($('textarea'));
            checkUpload($('#business'));
        });

    });
</script>
