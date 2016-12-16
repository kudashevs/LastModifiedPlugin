<?php
if ($modx->event->name == 'OnWebPagePrerender') {
	$dtm = ($modx->resource->get('editedon'))?strtotime($modx->resource->get('editedon')):strtotime($modx->resource->get('createdon'));
	if(empty($dtm)) { return ''; }

	$modx->log(modX::LOG_LEVEL_INFO,$_SERVER['REQUEST_URI'].' use '.$dtm.' date');
	if(!empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])){
		$ltm = strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']);
		if($dtm <= $ltm){
			$modx->log(modX::LOG_LEVEL_INFO,'Header 304 with document date '.$dtm.' and '.$ltm.' request date');
			header('HTTP/1.0 304 Not Modified');
			header('Last-Modified: '.gmdate('D, d M Y H:i:s',$dtm).' GMT');
			header('Cache-control: private, max-age=3600');
			header('Expires: '.gmdate('D, d M Y H:i:s',time()+3600));
			exit();
		}
	}
	header('Last-Modified: '.gmdate('D, d M Y H:i:s',$dtm).' GMT');
	header('Cache-control: private, max-age=3600');
	header('Expires: '.gmdate('D, d M Y H:i:s',time()+3600));
	return '';
}