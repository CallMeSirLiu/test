	
	Object.defineProperty(this, 'myClient', {
	    value: {},
	    writable: false
	});

	var client = myClient;

	/**
	 * 公共的 ajax 请求方法
	 * @DateTime 2017-06-29T15:21:07+0800
	 * @param    {[type]} type [请求类型  post,get,delete,put 等]
	 * @param    {[type]} url [请求的地址]
	 * @param    {[type]} dataObj [对象参数]
	 * @param    {[type]} successFn [成功回调]
	 * @param    {[type]} showLoading [第三方或者自定义 loading]
	 * @param    {[type]} errorFun [失败回调]
	 */
	client.doAjax = function (type, url, dataObj, successFn, showLoading, errorFun) {
    // dataObj['os'] ? '' : dataObj['os'] = 'web';
    // if (showLoading == undefined || showLoading == true) {
    //     layer.msg('正在加载,请稍候...', {icon: 16, time: 20000});//全局加载loading
    // }
    $.ajax({
        type: type,
        url: url,
        async: true,
        data: dataObj,
        timeout: 20000,
        dataType: 'json',
        beforeSend: function (xhr) {
        	console.log(xhr);
        	//返回 false 可取消本次 ajax 请求
        },
        success: function (responseData, textStatus, jqXHR) {
            if (responseData.status_code == 302 && responseData.redirect) {//重定向
                location.href = responseData.redirect;
                return;
            }
            // if (showLoading == undefined || showLoading == true) {
            //     layer.closeAll();//关闭loading
            // }
            successFn && successFn(responseData);
        },
        error: function (jqXHR, textStatus, exception) {
            var msg = exception == 'timeout' ? '请求超时,请重试' : '未知错误,请重试!';
            // layer.closeAll();//关闭loading
            // if (showLoading == undefined || showLoading == true) {
            //     layer.msg(msg, {icon: 2});
            // }
            errorFun && errorFun(jqXHR, textStatus, exception)
        }
    })
};

	/**
	 * 设置 cookie
	 * @DateTime 2017-06-29T15:01:50+0800
	 * @param    {[type]} c_name [description]
	 * @param    {[type]} value [description]
	 */
	client.setCookie = function(c_name,value){
		var exdate = new Date();
		exdate.setDate(exdate.getDate() + 360000);
		document.cookie = c_name + '=' + escape(value) + ";path=/;domain=.xx.com;max-age=360;expires=" + exdate.toGMTString();
	}

	/**
	 * 获取url 中的参数
	 * @DateTime 2017-06-29T15:16:19+0800
	 * @param    {[type]} name [description]
	 * @return   {[type]} [description]
	 */
	client.getUrlParam = function(name) {
		var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if(r != null) return unescape(r[2]);
		return null;
	}

	client.browser = {
		//浏览器类型
		versions : function(){
			var u = navigator.userAgent;
			return {
				mobile : !!u.match(/AppleWebKit.*Mobile.*/)||u.indexOf('iPad')>-1||u.indexOf('iPhone')>-1, //是否为移动终端
				ios : u.indexOf('iPad') > -1 || u.indexOf('iPhone') > -1,//ios
				android : u.indexOf('Android') > -1 || u.indexOf('Linux') > -1 //andorid或 uc 浏览器
			};
		}
	}

	client.gog = 'ceshi';

