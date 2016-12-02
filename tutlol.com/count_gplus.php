<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<font color="red" size="6">
<?php
	$url = 'https://plus.google.com/u/0/+huongvan-thanhcan/posts';
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
    
    $lang = 'en';
    $pos = strpos($content, '"Views of profile and its content. Values are approximate">');
    if ($pos === false) {
    	$pos = strpos($content, 'Giá trị mang tính tương đối">');
    	$lang = 'vi';
    }
    
    if ($pos !== false) {
    	if ($lang == 'vi') {
    		$pos += strlen('Giá trị mang tính tương đối">');
    	} else {
    		$pos += strlen('"Views of profile and its content. Values are approximate">');
    	}
    	$pos2 = strpos($content, '<', $pos + 1);
    	echo substr($content, $pos, $pos2 - $pos);
    } else {
    	echo 'Not found';
    }
	?>
	</font>