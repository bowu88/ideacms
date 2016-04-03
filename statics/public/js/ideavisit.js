/*
 * @Author: frank
 * @Date:   2016-04-02 20:27:51
 * @Last Modified by:   frank
 * @Last Modified time: 2016-04-03 20:10:38
 */

//获取浏览器
var browser, referrer;
var siteurl = 'test1.com';

if (navigator.userAgent.indexOf('MSIE') > 0) {
    browser = 'IE';

} else if (navigator.userAgent.indexOf('Firefox') > 0) {
    browser = "Firefox";
} else if (navigator.userAgent.indexOf('Opera') > 0) {
    browser = "Opera";
} else if (navigator.userAgent.indexOf('Chrome') > 0) {
    browser = "Chrome";
} else {
    browser = "other";
}

if (document.referrer.indexOf('baidu') >= 0) {
    referrer = "0";
} else if (document.referrer.indexOf('google') >= 0) {
    referrer = "1";
} else if(document.referrer.indexOf('bing') >= 0) {
    referrer = "2";
} else if(document.referrer.indexOf('soso') >= 0) {
    referrer = "3";
} else if(document.referrer.indexOf('sougou') >= 0) {
    referrer = "4";
} else if(document.referrer.indexOf(siteurl) >= 0) {
    referrer = "5";
} else if(document.referrer === ""){
  referrer = "6";
} else {
    referrer = "7";
}

//获取操作系统
function detectOS() {
var sUserAgent = navigator.userAgent;

var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");
var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel");
if (isMac) return "Mac";
var isUnix = (navigator.platform == "X11") && !isWin && !isMac;
if (isUnix) return "Unix";
var isLinux = (String(navigator.platform).indexOf("Linux") > -1);

var bIsAndroid = sUserAgent.toLowerCase().match(/android/i) == "android";
if (isLinux) {
if(bIsAndroid) return "Android";
else return "Linux";
}
if (isWin) {
var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1 || sUserAgent.indexOf("Windows 2000") > -1;
if (isWin2K) return "Win2000";
var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1 ||
sUserAgent.indexOf("Windows XP") > -1;
if (isWinXP) return "WinXP";
var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1 || sUserAgent.indexOf("Windows 2003") > -1;
if (isWin2003) return "Win2003";
var isWinVista= sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1;
if (isWinVista) return "WinVista";
var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1;
if (isWin7) return "Win7";
}
return "other";
}

//start ajax
$.ajax({
  type:'post',
  url:'/index.php?c=visit',
  data:{get:location.pathname+location.search,referrer:referrer,os:detectOS(),lang:navigator.language,browser:browser,ua:navigator.userAgent},
  dataType:'json',
});
