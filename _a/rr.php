<?php

class rr_grab {
	
	public function login() {
	
		$data_string = '94ae8903-13ed-4f85-b398-f4d028eeb1f3';
		 
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://rosreestr.ru/wps/portal/p/cc_ib_state_services/cc_ib_function/cc_ib_electronic_state/cc_ib_dostup_ir/!ut/p/c5/jZDBUoMwEIafpS_AbhIC4RhBIQEKFLGFSweZTGWmFKcqjm9v0UsvYneP33w7-__QwGVP7dQf2vd-PLVH2EHj7JFwSSIbVeaHHirGCtsT94iaXXh9xYV6lKgCETxUTyFDQW-xOU99FYcEs4rfocqLTGqNBJHcYqtQ59Fsh0WCqPygJLl0EXP8x9bQ9M-D9dkNFlquR1HYlBHPdajgHLZzE84-juJIeyWz1xcdFadaisyhmWK_fCn5zJeyzXzp-5_7f4xEWEfjYKCG2r1Kmfo-Sn8TySRJGYYI27N5Gz_OnYFNpYIEiq7tXkxiJnPM24OB16Gqdl-l6vMplXK1-gZQpozV/?windowName=2');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POST, true);                                                                  
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "/thawtePrimaryRootCA.crt");
		
		curl_setopt($ch, CURLOPT_ENCODING , "gzip");

		//curl_setopt($ch, CURLOPT_COOKIESESSION, true );
		//curl_setopt($ch, CURLOPT_COOKIE, 'JSESSIONID=0000l-ua8SvmmU4PvbTkgZOxACg:16k2q7k72; __utma=224553113.1103429637.1412086790.1412086790.1412086790.1; __utmc=224553113; __utmz=224553113.1412086790.1.1.utmcsr=word-view.officeapps.live.com|utmccn=(referral)|utmcmd=referral|utmcct=/wv/wordviewerframe.aspx');

		curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Host: rosreestr.ru',
		    										'User-Agent: Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:32.0) Gecko/20100101 Firefox/32.0',
		    										'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
													'Accept-Language: en-us,en;q=0.7,ru;q=0.3',
													'Accept-Encoding: gzip, deflate',
													'Content-Type: text/plain;charset=utf-8',
													'Referer: https://rosreestr.ru/wps/portal/p/cc_ib_state_services/cc_ib_function/cc_ib_electronic_state/cc_ib_dostup_ir',
                                                    'Cache-Control: no-cache',
                                                    'Connection: keep-alive',
                                                    'Pragma: no-cache',
                                                    'Cookie: JSESSIONID=0000l-ua8SvmmU4PvbTkgZOxACg:16k2q7k72; __utma=224553113.1103429637.1412086790.1412086790.1412086790.1; __utmc=224553113; __utmz=224553113.1412086790.1.1.utmcsr=word-view.officeapps.live.com|utmccn=(referral)|utmcmd=referral|utmcct=/wv/wordviewerframe.aspx',
		    										'Content-Length: ' . strlen($data_string))
		);

		$result = curl_exec($ch);

		if (curl_errno($ch)) {
          throw new Exception('Error: ' . curl_error($ch));
        }
		
		return $result;
	}
}

$r = new rr_grab();
try{
	echo $r->login();
}
catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}