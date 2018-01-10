<?php
/**
 * Created by PhpStorm.
 * User: 方圆
 * Date: 2018-1-11
 * Time: 1:58
 */


?>

<!--开始-英汉翻译-->
<div class="tab-a-item">
	<!--查询元-->
    <!--输入域textarea在Android 下拉刷新时表现的不够优秀，所以替换成了div-->
	<div class="tran-texta en-res" id="en-res" contenteditable="true" ></div>
	<div class="btn-go-zone"  oncontextmenu="return false" onselectstart="return false">
		<span class="tab-to-btn">to</span>
		<span class="tab-go-btn en-tran-btn click">立即翻译</span>
		<div class="clear"></div>
	</div>
	<div>
		<div class='en-alert' style='color: green;margin-bottom: 5px;font-size: 12px;'></div>
		<!--显示结果-->
		<div class="tran-sult-en tran-sult en-zh-sult" id="tran-sult"></div>
	</div>
</div>
<script>
    var tran_txt_en ;//取值校验
    $(".en-tran-btn").click(function(){
        var tran_txt = $(".en-res").text();//取值
        var tran_reslt = $(".en-zh-sult");//翻译结果显示区域
        var tran_url = "http://xxxxxxxxxxxxxxxxx/tran/index.php?tran=" + tran_txt;//英译汉翻译接口
        $(".tran-sult-en").html(
            '                        <div class="tran-info-en"></div>' +
            '                        <hr />' +
            '                        <div class="exp-info-en">' +
            '                            <div style="margin-left: -10px;">【基本解释】</div>' +
            '                        </div>' +
            '                        <div class="web-info-en">' +
            '                            <div style="margin-left: -10px;">【网络解释】</div>' +
            '                        </div>');
        if (!tran_txt){
            tran_reslt.html("<span style='color: red;'>（英文翻译源为空）</span>");
        }else {

            //校验是否重复翻译，避免乱刷
            if (tran_txt_en === tran_txt){
                //连续重复查
                $(".en-alert").html("");
            }else {

                $(".en-alert").html("");
                tran_txt_en = $(".en-res").text();
                $.getJSON(tran_url, function(dataObj, status){
                    console.log(status);
                    //必选
                    $(".q-info-en").append("<h4>查询词："+dataObj.query+"</h4>");
                    //必选
                    for (m=0;m<dataObj.translation.length;m++) {
                        $(".tran-info-en").append("<div>"+dataObj.translation[m]+"</div>");
                    }
                    //非必。基本解释
                    if(typeof(dataObj.basic) === "undefined"){
                        console.log("你查询的是句子1");
                        $(".exp-info-en").hide();
                    }else{
                        for (j=0;j<dataObj.basic.explains.length;j++) {
                            $(".exp-info-en").append("<div style='font-weight: 500;'>"+dataObj.basic.explains[j]+"</div>");
                        }
                    }
                    //非必
                    $(".exp-info-en").append("<hr/>");
                    //非必。网络解释
                    if(typeof(dataObj.web) === "undefined"){
                        console.log("你查询的是句子2");
                        $(".web-info-en").hide();
                    }else{
                        for (i=0;i<dataObj.web.length;i++) {
                            $(".web-info-en").append("<p>相关示意："+dataObj.web[i].key+"</p>");
                            for (ii=0;ii<dataObj.web[i].value.length;ii++) {
                                $(".web-info-en").append("<div>"+dataObj.web[i].value[ii]+"</div>");
                            }
                        }
                    }
                });

            }
        }
    });
</script>
<!--结束-英汉翻译-->


<style>
    .tran-content{
        width: 100%;
        min-height: 500px;
        overflow-x: hidden;
        background: white;
    }
    .tran-texta{
        background: whitesmoke;
        color: grey;
        font-size: 15px;
        font-weight: 500;
        min-height: 80px;
        width: calc(100% - 20px);
        resize: none;
        /*overflow-y:scroll;*/
        overflow-x: hidden;
        border-radius: 5px;
        padding: 5px 8px;
        border: none;
        line-height: 23px;
        box-shadow: wheat 0 0 5px;
    }

    .tran-sult{
        background: #EEEEEE;
        color: #1A1A1A;
        font-size: 15px;
        font-weight: 600;
        min-height: 20px;
        /*max-height: 260px;*/
        width: calc(100% - 20px);
        resize: none;
        /*overflow-y:scroll;*/
        overflow-x: hidden;
        border-radius: 5px;
        padding: 5px 8px;
        border: none;
        line-height: 23px;
        box-shadow: wheat 0 0 5px;
    }

    .clear{
        clear: both;
    }
    .click{

    }
    .click:hover{
        opacity: 0.8;

    }
    .click:active{
        opacity: 0.6;

    }
    .btn-go-zone{
        margin:  15px 0px;
    }
    .tab-go-btn{
        padding: 8px 30px;
        font-size: 16px;
        letter-spacing: 2px;
        color: white;
        background: #00ADEA;
        border-radius: 30px;
        /*line-height: 32px;*/
        margin-right: 0px;
        cursor: pointer;
        float: right;
    }
    .tab-to-btn{
        padding: 8px 0px;
        font-size: 16px;
        letter-spacing: 1px;
        color: grey;
        /*background: #3A5FCD;*/
        border-radius: 5px;
        /*line-height: 32px;*/
        margin-right: 0px;
        cursor: pointer;
        float: left;
    }

    .web-info-en{
        /*display: none;*/
    }

</style>