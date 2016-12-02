<?php
	date_default_timezone_set('Asia/Saigon');
	$ul = '';
	$url = 'https://lienminh.garena.vn/index.php';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$content = curl_exec($ch);
	curl_close($ch);
	$p1 = strpos($content, '<h2 class="titleBox">TƯỚNG MIỄN PHÍ TRONG TUẦN</h2>');
	if ($p1 !== false) {
		$p1 += strlen('<h2 class="titleBox">TƯỚNG MIỄN PHÍ TRONG TUẦN</h2>');
		$p2 = strpos($content, '</div>', $p1 + 1);
		if ($p2 !== false) {
			$ul = substr($content, $p1, $p2 - $p1);
		}
	}
	$ok = preg_match_all('@<img src="([^"]+)" class="img" title="([^"]+)"@', $ul, $matches, PREG_SET_ORDER);
	$arrTuong = array();
	if ($ok) {
		foreach ($matches as $m) {
			$name = $m[2];
			$icon = 'https://lienminh.garena.vn/index.php' . $m[1];
			$url = 'http://www.modskinlol.com/search/label/' . $name . '?max-results=10';
			$arrTuong[] = array('name' => $name, 'icon' => $icon, 'url' => $url);
		}
	}
	$html = "<ul style='width: 2980px; margin-top: 0px;'><li>";
	$index = 1;
	$dataname = "";
	foreach ($arrTuong as $tuong) {
		$html .= "<div class='champion_quicklist_icon_week inline'>
	<div class='champion_select medium_champion_0' id='t000_".$index++."' alt='#' name='#'>
	<a href='".$tuong['url']."' imageanchor='1' style='margin-left: 1em; margin-right: 1em;'><img border='0' width='80' height='80' src='".$tuong['icon']."'/></a>
	</div>".$tuong['name']."</div>" . PHP_EOL;
	$dataname .= $tuong['name'] . "; ";
	}
	$html .= '</li></ul>';
	$x = array('data' => $html);
	//header('Content-Type: application/javascript');
	
	$data = "// author: huypv, nhancm - Last scan: " . date("Y/m/d - h:m:s") . "\n";
	$data .= "var ______x = " . json_encode($x) . "; \n";
	$data .= "document.getElementById(\"champions_week_hero\").innerHTML = ______x.data;";
	
	$h = fopen('/var/lib/openshift/57a2ae240c1e6642ef000131/app-root/data/current/tutlol.com/freechampion.js','w');
	if (!$h) echo "Could not write to cache";
	if (fwrite($h,$data)===false) {
      echo "Could not write to cache";
    }
    fclose($h);
	
	$h = fopen('/var/lib/openshift/57a2ae240c1e6642ef000131/app-root/data/current/tutlol.com/freechampion.txt','w');
	if (!$h) echo "Could not write to cache";
	if (fwrite($h,$dataname)===false) {
      echo "Could not write to cache";
    }
    fclose($h);
?>