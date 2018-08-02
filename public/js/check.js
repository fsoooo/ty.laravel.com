/**
 * Created by dell01 on 2017/7/7.
 */
//写一个方法，用来验证


    function check(dom,dom_val,pattern,name)
    {
        if(dom == ''){//手机验证
            dom.parent().addClass("has-error");
            return false;
        }else if(!pattern.test(dom_val)) {
            dom.parent().addClass("has-error");
            return false;
        }else {
            dom.parent().removeClass("has-error");
            return true;
        }
    }

