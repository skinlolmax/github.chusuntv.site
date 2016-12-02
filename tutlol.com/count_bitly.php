<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<center>
<font color="red" size="6">
<?php
	$url = 'https://bitly.com/zipmodskin+';
	$options = array(
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER         => false,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING       => "",
        CURLOPT_USERAGENT      => "",
        CURLOPT_AUTOREFERER    => true,
        CURLOPT_CONNECTTIMEOUT => 10,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_MAXREDIRS      => 10,
        CURLOPT_SSL_VERIFYPEER => false
    );

    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    #$header  = curl_getinfo( $ch );
    curl_close( $ch );
    
    
    $pos = strpos($content, '<div class="donut-total-num-clicks h1">');
    if ($pos !== false) {
    	$pos += strlen('<div class="donut-total-num-clicks h1">');
    	$pos2 = strpos($content, '<', $pos + 1);
    	echo substr($content, $pos, $pos2 - $pos);
    } else {
    	echo 'Download';
    }
?>
</font>
</center>