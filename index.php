<?php
/**
 * Created by PhpStorm.
 * User: 方圆
 * Date: 2018-1-11
 * Time: 1:21
 */

//【1/3】填写你的密钥相关
define("CURL_TIMEOUT",   20);
define("URL",            "http://openapi.youdao.com/api");
define("APP_KEY",         "xxxxxxx"); //替换为您的APPKey
define("SEC_KEY",        "xxxxxxxxxxxxxxxxx");//替换为您的密钥


//关键文件，不用修改
include "make_tran.php";

//【2/3】防止恶意刷新模块，1.2 秒时间间隔限制
limitReload(1.2);//单位s

/**
 * 防止恶意刷新模块
 * $this->limitReload(0.8); //单位s
 * 实现原理 设置 max_reloadtime = 2; //设置页面刷新最长间隔时间，单位s
 * 用户第一次打开页面 记录当前的时间保存在 session_start
 */
function limitReload($max_reloadtime){//单位s

	session_start();
	if(empty($_SESSION["session_start"])){  //初始session
		$_SESSION["session_start"] =time();
	}else{
		$time_passed =time();
		if($time_passed - $_SESSION["session_start"] > $max_reloadtime){//正常刷新

			//【3/3】翻译源，get方法，可以查询单词或者整句，并返回json结果集
			//api例子：http://120.77.200.230/tp32app/tran/index.php?tran=ok 返回“ok”的查询json结果
			$tran = $_GET["tran"] ;
			//$tran = "He is Good!";
			//调用翻译的规则：日文ja、英文EN、法文fr、韩文ko、简体汉语zh-CHS
			translate($tran,"EN","zh-CHS");

		}else{//恶意刷新
			$erro_json = '{"translation": ["（可能的恶意查询）"],"basic": {"explains": ["（查词太快了，不符合正常人的查询速度）"]}}';
			echo $erro_json;
			return false;
		}
		$_SESSION["session_start"] =time();

	}

	return true;
}