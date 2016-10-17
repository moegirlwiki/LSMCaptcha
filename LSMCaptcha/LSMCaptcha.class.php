<?php

/**
 * LSMCaptcha class
 *
 * @file
 * @author 934131 <2241448500@qq.com>
 * @ingroup Extensions
 * @version v1.0.0
 */
class LSMCaptcha extends SimpleCaptcha {
	protected static $messagePrefix = 'lsmcaptcha-';

	/** Validate a captcha response */

	function keyMatch( $answer, $info ) {
global $wgLSM_API_KEY;
if (!empty($_POST["luotest_response"])){
$url= "https://captcha.luosimao.com/api/site_verify";
$data = array (
'api_key' => $wgLSM_API_KEY,
'response' => $_POST["luotest_response"]
);
$re=$this->postData($url,$data);
$re=json_decode($re,true);
if (!empty($re["res"])){
if ($re["res"]=="success"){return true;}else{return false;}}else{return false;}
}else{return false;}
	}

function postData($url, $data)  
    {  
        $ch = curl_init();  
        $timeout = 10;   
        curl_setopt($ch, CURLOPT_URL, $url);  
        curl_setopt($ch, CURLOPT_POST, true);  
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);  
        $handles = curl_exec($ch);  
        curl_close($ch);  
        return $handles;  
    }

	function addCaptchaAPI( &$resultArr ) {
		$captcha = $this->getCaptcha();
		$index = $this->storeCaptcha( $captcha );
		$resultArr['captcha'] = $this->describeCaptchaType();
		$resultArr['captcha']['id'] = $index;
		$resultArr['captcha']['question'] = $captcha['question'];
	}

	public function describeCaptchaType() {
		return [
			'type' => 'lsmcaptcha',
			'mime' => 'text/plain',
		];
	}

	function getCaptcha() {
		return [ 'question' => 'Captcha', 'answer' => '0'];
	}

	function getForm( OutputPage $out, $tabIndex = 1 ) {
global $wgLSM_SITE_KEY;
	$out->addHeadItem(
			'lsmscript',
			'<script defer src="//captcha.luosimao.com/static/dist/api.js"></script>'
		);
		$captcha = $this->getCaptcha();
		if ( !$captcha ) {
			die(
				"No questions found; set some in LocalSettings.php using the format from LSMCaptcha.php."
			);
		}
		$index = $this->storeCaptcha( $captcha );
		return "<p><label type='hidden' for=\"wpCaptchaWord\"></label> " .
     Xml::element( 'input', [
				'type'  => 'hidden',
				'name'  => 'LSMCaptchaCC',
				'id'    => 'LSMCaptchaCC',
				'value' => 'This captcha plugin is powered by 934131.'] ).
			Html::element( 'input', [
				'name' => 'wpCaptchaWord',
				'id'   => 'wpCaptchaWord',
				'class' => 'mw-ui-input',
       'type' => 'hidden',
				'required',
				'autocomplete' => 'off',
				'tabindex' => $tabIndex ] ) .// tab in before the edit textarea
			"</p>\n" .
			Xml::element( 'input', [
				'type'  => 'hidden',
				'name'  => 'wpCaptchaId',
				'id'    => 'wpCaptchaId',
				'value' => $index ] ).'<div class="l-captcha" data-site-key="'.$wgLSM_SITE_KEY.'"></div><br />';
	}

	function showHelp() {
		global $wgOut;
		$wgOut->setPageTitle( wfMessage( 'captchahelp-title' )->text() );
		$wgOut->addWikiMsg( 'lsmcaptchahelp-text' );
		if ( CaptchaStore::get()->cookiesNeeded() ) {
			$wgOut->addWikiMsg( 'captchahelp-cookies-needed' );
		}
	}

	public function getCaptchaInfo( $captchaData, $id ) {
		return $captchaData['question'];
	}
}
