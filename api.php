<?php
header("Content-Type: application/json;charset=utf-8");

// Coded by Versailles - Sec7or Team
// Don't Change Copyright

function curl($url){
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_REFERER, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) ChromeHD/52.0.2743.82 Safari/537.36');
$ret = curl_exec($ch);
$ret = str_replace(urldecode('%0A'), '', $ret);
return $ret;
}

if(isset($_GET['p'])){

$fa = curl("https://www.samehadaku.net/page/".$_GET['p']);
preg_match_all('/<figure class="mh-posts-list-thumb">(.*?)<\/article>/',$fa,$a);

foreach($a[1] as $ar){

preg_match('/class="mh-excerpt-more" href="https:\/\/www.samehadaku.net\/(.*?).html" title="(.*?)"/',$ar,$l);

preg_match('/<img width="326" height="245" src="(.*?)"/',$ar,$i);

$z['title'] = $l[2];
$z['images'] = $i[1];
$z['link'] = $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF']."?v=".$l[1];

$zo[] = $z;
}

echo json_encode($zo, JSON_PRETTY_PRINT);
}


if(isset($_GET['v'])){

$f = curl("https://www.samehadaku.net/".$_GET['v'].".html");

preg_match('/<p><strong>(.*?)<\/strong>/',$f,$ti); // title

preg_match('/rilis tanggal (.*?).<\/p>/',$f,$re); //release

preg_match('/Sinopsis (.*?)<\/span>/',$f,$si); //sinopsis

preg_match('/Genres: (.*?)<\/span>/',$f,$gr); //genre

preg_match('/Penerjemah: (.*?)<\/span>/',$f,$tr); // translator

preg_match('/Encoder: (.*?)<\/span>/',$f,$en); //encoder

preg_match('/Uploader: (.*?)<\/span>/',$f,$up); //uploader


preg_match('/<div class="download-eps">(.*?)<\/div>/',$f,$ep);

preg_match_all('/<li style="text-align: center;">(.*?)<\/li>/',$ep[1],$l);

foreach($l[1] as $link){
preg_match('/<strong>(.*?)<\/strong>/',$link,$q); //Quality
preg_match_all('/href="(.*?)"/',$link,$lin);



$l1 = curl($lin[1][0]);
preg_match('/<div class="download-link" style="text-align:center;text-decoration:underline;font-size:20px;"><a href="(.*?)"/',$l1,$uf1);
$uf = base64_decode(str_replace('http://coeg.in/?r=','',$uf1[1]));


$l2 = curl($lin[1][1]);
preg_match('/<div class="download-link" style="text-align:center;text-decoration:underline;font-size:20px;"><a href="(.*?)"/',$l2,$cu1);
$cu = base64_decode(str_replace('http://coeg.in/?r=','',$cu1[1]));

$l3 = curl($lin[1][2]);
preg_match('/<div class="download-link" style="text-align:center;text-decoration:underline;font-size:20px;"><a href="(.*?)"/',$l3,$gd1);
$gd = base64_decode(str_replace('http://coeg.in/?r=','',$gd1[1]));

$l4 = curl($lin[1][3]);
preg_match('/<div class="download-link" style="text-align:center;text-decoration:underline;font-size:20px;"><a href="(.*?)"/',$l4,$zs1);
$zs = base64_decode(str_replace('http://coeg.in/?r=','',$zs1[1]));


$l5 = curl($lin[1][4]);
preg_match('/<div class="download-link" style="text-align:center;text-decoration:underline;font-size:20px;"><a href="(.*?)"/',$l5,$sc1);
$sc = base64_decode(str_replace('http://coeg.in/?r=','',$sc1[1]));


$li['QUALITY'] = $q[1];
$li['UF'] = $uf;
$li['CU'] = $cu;
$li['GD'] = $gd;
$li['ZS'] = $zs;
$li['SC'] = $sc;

$o[] = $li;
}

$out['title'] = $ti[1];
$out['release'] = $re[1];
$out['sinopsis'] = $si[1];
$out['genre'] = $gr[1];
$out['translator'] = $tr[1];
$out['encoder'] = $en[1];
$out['uploader'] = $up[1];
$out['download'] = $o;

echo json_encode($out, JSON_PRETTY_PRINT);
}
