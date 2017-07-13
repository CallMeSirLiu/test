<?php

	C('SHOW_PAGE_TRACE',false);
	$output = $this->output;
	$uid = $this->userid;

	if($_FILES){
		//判断是否有该目录
		$path = $_SERVER['DOCUMENT_ROOT'].__ROOT__."/Upload/avatar/";
		if(!is_dir($path)){
			mkdir($path,0777,true);
		}

		if(!is_dir($path.'150/')){
			mkdir($path.'150/',0777,true);
		}
		if(!is_dir($path.'50/')){
			mkdir($path.'50/',0777,true);
		}

		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     2097152 ;// 设置附件上传大小2M
		$upload->exts      =     array('jpg','jpeg','png','bmp');// 设置附件上传类型
		$upload->autoSub   =  false;
		$upload->rootPath  =     $_SERVER['DOCUMENT_ROOT'].__ROOT__."/Upload";
		$upload->savePath  =      '/avatar/';
		// 上传单个文件
		$info   =   $upload->uploadOne($_FILES['file']);
		if(!$info) {
    			$output['msg'] = $upload->getError();			
		}else{
			$path = $_SERVER['DOCUMENT_ROOT'].__ROOT__."/Upload/avatar/";
			if(file_exists($path.$info['savename'])){
				$img = new \Think\Image();
				$img->open($path.$info['savename']);
				$img->thumb(150,150)->save($path.'150/150_'.$info['savename']);
				$img->thumb(50,50)->save($path.'50/50_'.$info['savename']);
				$array = array('uid'=>($this->trueid),'avatar'=>$info['savename']);
				//删除之前的
				$uinfo = D('user')->getUserInfo($this->trueid);
				$output = D('user')->editInfo($array);
				$output['info'] = $info;
				$output['data_id'] = $uid;
				if($output['r'] == 1){
					//删除之前的
					$this->delOldAvatar($uinfo['data']['avatar']);
				}
			}
		}else{
			$output['msg'] = '文件丢失';
			$output['tip'] = '表单提交错';		
		}
		$model = json_encode($output);
		$callback = "<script>parent.uploadCallback($model);</script>";
		$this->show($callback);
	}
?>