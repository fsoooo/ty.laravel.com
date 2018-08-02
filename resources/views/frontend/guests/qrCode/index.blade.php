<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>团险添加人员信息录入表</title>
    <link rel="stylesheet" href="/r_backend/css/bootstrap/bootstrap.min.css">
    <script src="/r_backend/js/jquery.js"></script>
    <script src="/r_backend/js/bootstrap.js"></script>
</head>
<body>
<div style="margin: 50px auto;width: 500px;">
    <form class="form-horizontal" action="" method="">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name"  placeholder="被保人姓名">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">年龄</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="age" placeholder="年龄">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">证件类型</label>
            <div class="col-sm-10">
                <select name="id_type"  class="form-control">
                	<option value="1">身份证</option>
                	<option value="2">护照</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">证件号码</label>
            <div class="col-sm-10">
                <input type="text" name="id_code"  class="form-control" value=""  required="required" placeholder="请填写被保人证件号码">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">出生日期</label>
            <div class="col-sm-10">
                <input type="text" name="date"  class="form-control" value=""  required="required" placeholder="请填写被保人出生日期">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">性别</label>
            <div class="col-sm-10">
                <input type="text" name="sex"  class="form-control" value=""  required="required" placeholder="请填写被保人性别">
            </div>
        </div>
        <div class="form-group">
            <label for="inputPassword3" class="col-sm-2 control-label">职业代码</label>
            <div class="col-sm-10">
                <input type="text" name="occupation"  class="form-control" value=""  required="required" placeholder="详情看职业代码手册" >
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">提交</button>
            </div>
        </div>
    </form>
</div>


</body>
</html>