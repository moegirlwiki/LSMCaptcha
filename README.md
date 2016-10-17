# LSMCaptcha
Luosimao人机验证 for Mediawiki

## 下载

[v1.0.0(2016-10-17)](https://github.com/Netrvin/LSMCaptcha/releases/tag/v1.0.0)

## 安装

1.确保你已经安装ConfirmEdit插件（对于ConfirmEdit的其它配置，请查看其官网：[https://m.mediawiki.org/wiki/Extension:ConfirmEdit](https://m.mediawiki.org/wiki/Extension:ConfirmEdit)）

============================

2.把与本文件同目录的LSMCaptcha.php文件和LSMCaptcha目录拷贝到Mediawiki的/extensions/ConfirmEdit目录下

============================

3.修改LocalSettings.php以启用插件，添加以下代码（记得注释或删除原启用的验证码插件的安装代码）

// Mediawiki版本大于或等于1.25<br />
wfLoadExtensions( array( 'ConfirmEdit', 'ConfirmEdit/LSMCaptcha' ) );<br />
// 其它Mediawiki版本<br />
require_once "$IP/extensions/ConfirmEdit/ConfirmEdit.php";<br />
require_once "$IP/extensions/ConfirmEdit/LSMCaptcha.php";

============================

4.设置网站的sitekey和apikey，方法为在LocalSetting.php内添加如下代码（sitekey和apikey请用你自己申请获得的来替换，申请地址：[https://luosimao.com/service/captcha](https://luosimao.com/service/captcha)）

$wgLSM_SITE_KEY="sitekey";<br />
$wgLSM_API_KEY="apikey";

============================

5.尽情享受新的人机验证吧！

## 关于
作者：[934131](http://won.cx/)
