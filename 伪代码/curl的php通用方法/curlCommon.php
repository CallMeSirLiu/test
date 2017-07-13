<?php
	
	/**
	 * [php中的 curl通用函数,调用了些额外的方法，可以自己实现]
	 * @Author   LiuJia
	 * @DateTime 2017-07-13T10:31:09+0800
	 * @param    [type] $url [description]
	 * @param    [type] $data [description]
	 * @param    string $method [description]
	 * @return   [type] [description]
	 */
	public function commonCurl($url,$data = null,$method = 'get'){
    	$baseUrl = ' xxxxxx';

    	$url = $baseUrl . $url;
		$timeout = 5000;  

		$ch = curl_init(); 
		curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_HEADER, false ); 
		// curl_setopt ($ch, CURLOPT_HTTPHEADER,0);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER,false); //处理http证书问题  
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout); 
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);//返回给变量

		if($method === 'post'){

	        curl_setopt ($ch, CURLOPT_POST, 1);
		    $post_data = http_build_query($data);
	    	curl_setopt ($ch,CURLOPT_POSTFIELDS, $post_data);
			
		}else if($method === 'put' or $method === 'delete'){

			$post_data = http_build_query($data);
			$method = strtoupper($method);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: ' . strlen($post_data)));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
	    	curl_setopt ($ch, CURLOPT_POSTFIELDS, $post_data);

		}else if($method === 'get'){

			$paramStr = $this->getParamString($data);
			$url .= $paramStr;
			curl_setopt ($ch, CURLOPT_URL, $url);
		}
		
		$result = curl_exec($ch);  
        if (false === $result) {
            $result =  curl_errno($ch);
        }

		curl_close($ch);  
		return json_decode($result,true) ;
    }


?>