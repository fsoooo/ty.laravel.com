<!--记录沟通弹出层-->
<div class="popups-wrapper popups-handle popups-record" style="display: none;">
    <div class="popups">
        <div class="popups-title">
            <i class="iconfont icon-close"></i>
            <div class="select-header">
                <span class="select-item active">添加沟通记录</span>
                <span class="select-item">查看沟通记录</span>
            </div>
        </div>
        <div class="popups-content">
            <div class="content select-content">

                <div class="select-item" style="display: block;">
                    <div class="content">
                        <div class="section">
                            <div class="section-title">第一步,选择客户</div>
                            <div class="section-container">
                                <div class="search-outer">
                                    <div class="select-box">
                                        <label>
                                            <i class="iconfont icon-danxuanxuanzhong"></i>个人客户
                                            <input hidden checked type="radio" name="clientType1"/>
                                        </label>
                                        <label>
                                            <i class="iconfont icon-danxuan"></i>企业客户
                                            <input hidden type="radio" name="clientType1"/>
                                        </label>
                                    </div>
                                    <div class="search-wrapper">
                                        <select>
                                            <option>姓名</option>
                                            <option>身份证</option>
                                            <option>手机号</option>
                                            <option>邮箱</option>
                                            <option>别名</option>
                                        </select>
                                        <input placeholder="搜索客户">
                                        <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                                    </div>
                                </div>
                                {{--<div class="z-btn-hollow reelect">重<br>选</div>--}}
                                <div id="client" class="table-wrapper client-wrapper">
                                    <ul class="table-header">
                                        <li>
                                            <span class="col1"></span>
                                            <span class="col2">姓名</span>
                                            <span class="col3">性别</span>
                                            <span class="col4">出生日期</span>
                                            <span class="col5">职业</span>
                                            <span class="col6">证件号码</span>
                                            <span class="col7">电话号</span>
                                            <span class="col8">邮箱</span>
                                        </li>
                                    </ul>
                                    <div class="table-body" style="overflow: hidden;">
                                        <ul style="top: 0px; position: absolute;">
                                            <li>
                                                <span class="col1">
                                                    <label>
                                                        <input hidden="" type="radio" name="user">
                                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                                    </label>
                                                </span>
                                                <span class="col2">天小眼</span>
                                                <span class="col3">女</span>
                                                <span class="col4">1993.10.15</span>
                                                <span class="col5">快递员</span>
                                                <span class="col6">1235545546415457889</span>
                                                <span class="col7">15648975246</span>
                                                <span class="col8">156489545@qq.com</span>
                                            </li>
                                        </ul>
                                        <div style="position:absolute;line-height:0;" class="zUIpanelScrollBox"></div><div style="position:absolute;line-height:0;" class="zUIpanelScrollBar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section">
                            <div class="section-title">第二步,选择产品</div>
                            <div class="section-container">
                                <div class="search-outer">
                                    <div class="search-wrapper">
                                        <select>
                                            <option value="">产品名称</option>
                                            <option value="">公司名称</option>
                                            <option value="">产品分类</option>
                                            <option value="">佣金比率</option>
                                            <option value="">主险条款</option>
                                        </select>
                                        <input placeholder="搜索产品">
                                        <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                                    </div>
                                </div>
                                {{--<div class="z-btn-hollow reelect">重<br>选</div>--}}
                                <div id="product" class="table-wrapper product-wrapper">
                                    <ul class="table-header">
                                        <li>
                                            <span class="col1"></span>
                                            <span class="col2">产品ID</span>
                                            <span class="col3">公司名称</span>
                                            <span class="col4">产品类型</span>
                                            <span class="col5">产品名称</span>
                                            <span class="col6">主险</span>
                                            <span class="col7">佣金比率</span>
                                            <span class="col8">保费</span>
                                        </li>
                                    </ul>
                                    <div class="table-body" style="overflow: hidden;">
                                        <ul style="top: 0px; position: absolute;">
                                            <li>
                                                <span class="col1">
                                                    <label>
                                                        <input hidden="" type="radio" name="product">
                                                        <i class="iconfont icon-duoxuan-weixuan"></i>
                                                    </label>
                                                </span>
                                                <span class="col2">123</span>
                                                <span class="col3">平安保险</span>
                                                <span class="col4">人寿险</span>
                                                <span class="col5">安心七日游</span>
                                                <span class="col6">鸿福至尊（分红型）</span>
                                                <span class="col7">10%</span>
                                                <span class="col8">500</span>
                                            </li>
                                        </ul>
                                        <div style="position:absolute;line-height:0;" class="zUIpanelScrollBox"></div><div style="position:absolute;line-height:0;" class="zUIpanelScrollBar"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="section section-record">
                            <div class="section-title">第三步,记录详情</div>
                            <div class="section-container">
                                <div style="margin-bottom: 20px;">
                                    <span class="name">购买意向</span>
                                    <div class="satisfaction-wrapper">
                                        <span class="satisfaction">
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                            <i class="iconfont icon-icon-manyidu"></i>
                                        </span>
                                        <span class="score">0分</span>
                                    </div>
                                </div>
                                <div>
                                    <span class="name">沟通详情</span>
                                    <textarea id="details" placeholder="请输入沟通内容"></textarea>
                                </div>
                            </div>
                        </div>
                        <button id="addRecord" class="z-btn z-btn-positive">添加</button>
                    </div>
                </div>

                <div class="select-item look">
                    <div class="search-outer">
                        <div class="select-box">
                            <label>
                                <i class="iconfont icon-danxuanxuanzhong"></i>个人客户
                                <input hidden checked type="radio" name="clientType2"/>
                            </label>
                            <label>
                                <i class="iconfont icon-danxuan"></i>企业客户
                                <input hidden type="radio" name="clientType2"/>
                            </label>
                        </div>

                        <div class="search-wrapper">
                            <select>
                                <option>姓名</option>
                                <option>身份证</option>
                                <option>手机号</option>
                                <option>邮箱</option>
                                <option>别名</option>
                            </select>
                            <input placeholder="搜索客户">
                            <button class="z-btn z-btn-default"><i class="iconfont icon-sousuo"></i></button>
                        </div>
                    </div>

                    <div>
                        <table class="table-hover">
                            <tbody>
                            <thead>
                            <tr>
                                <th width="10%">沟通时间</th>
                                <th width="20%">客户</th>
                                <th width="25%">产品名称</th>
                                <th width="15%">购买意向</th>
                                <th width="30%">记录详情</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>2017-10-01</td>
                                <td>天小眼</td>
                                <td>平安盗不怕保障计划一</td>
                                <td class="color-positive">2分</td>
                                <td>第二次沟通，客户由于前天家中被盗，有意向购买保险，获取了客户基本信息。
                                    <div class="operation">
                                        <div class="operation-item"><i class="iconfont icon-edit"></i><p>修改</p></div>
                                        <div class="operation-item"><i class="iconfont icon-delete"></i><p>删除</p></div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            </tbody>
                        </table>
                    </div>

                    <ul class="pagination">
                        <li class="disabled"><span>«</span></li>
                        <li class="active"><span>1</span></li>
                        <li><a>2</a></li>
                        <li><a>3</a></li>
                        <li><a rel="next">»</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!--成功添加记录沟通弹出层-->
<div class="popups-wrapper popups-success">
    <div class="popups">
        <div class="popups-title">新增沟通记录<i class="iconfont icon-close"></i></div>
        <div class="popups-content">
            <i class="iconfont icon-shenqingchenggong"></i>
            <p>添加成功</p>
            <div>
                <button class="z-btn z-btn-positive">继续添加沟通记录</button>
                <button class="z-btn-hollow">查看已添加沟通记录</button>
            </div>
        </div>
    </div>
</div>
