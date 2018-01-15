<?php
 
define('ROOT_PATH', '/home/upload');
define('TORRENT_PATH', ROOT_PATH.'/torrent'); 
define('SITE_ROOT', 'https://test.site');
define('Q_LOGIN', 'https://test.site/pagelogin.php?qlogin=176b4490e19018f0f4ff65526f6ca6dcb5dc2128199656bc18b2f39c06840f7afb41054c629efa6c156b97c85674a40d');
 
function make_login()
{
	$login_url = Q_LOGIN;
	$ch = curl_init($login_url);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt');
	$rez = curl_exec($ch);
	if (!$rez) die('Cannot login!');
}
 
make_login();
 
	$login_url = SITE_ROOT.'/mytorrents.php';
	$ch = curl_init($login_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	$rez = curl_exec($ch);
 
	preg_match_all('/download\.php\?torrent=([0-9]+)/', $rez, $sub);
	//print_r($sub);
	foreach ($sub[0] as $id)
	{
	$download_url = SITE_ROOT.'/'.$id;
	$ch = curl_init($download_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt');
	$rez = curl_exec($ch);
	$id = str_ireplace('download.php?torrent=', '', $id);
	file_put_contents(TORRENT_PATH.'/'.$id.".torrent", $rez);
	}

?>
