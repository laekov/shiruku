<?php
if (!defined('srkVersion')) {
	exit(403);
}

function echoQzoneShare() { 
?>
<script type="text/javascript">
(function(){
var p = {
url:location.href,
showcount:'1',/*是否显示分享总数,显示：'1'，不显示：'0' */
desc:'',/*默认分享理由(可选)*/
summary:'',/*分享摘要(可选)*/
title:'',/*分享标题(可选)*/
site:'from laekov.com.cn',/*分享来源 如：腾讯网(可选)*/
pics:'', /*分享图片的路径(可选)*/
style:'103',
width:135,
height:22
};
var s = [];
for(var i in p){
s.push(i + '=' + encodeURIComponent(p[i]||''));
}
document.write(['<a version="1.0" class="qzOpenerDiv" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?',s.join('&'),'" target="_blank">分享</a>'].join(''));
})();
</script>
<script src="https://qzonestyle.gtimg.cn/qzone/app/qzlike/qzopensl.js#jsdate=20111201" charset="utf-8"></script>
<?php }

