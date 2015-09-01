<?php
$obj=new stdClass();
if(empty($_POST['pageId']) or empty($_POST['port'])){
	$obj->error='Не передан один из параметров';
}else{
	$_POST['pageId']=trim($_POST['pageId']);
	$_POST['port']=trim($_POST['port']);
	if(!is_numeric($_POST['pageId']))
		$obj->error='Не верный формат pageId (Должно быть целым числом)';
	if(!is_numeric($_POST['port']))
		$obj->error='Не верный формат port (Должно быть целым числом)';
	if(empty($obj->error)){
		$obj->port=(int)$_POST['port'];
		$obj->pageId=(int)$_POST['pageId'];
		switch($obj->pageId){
			case 1:
				$obj->pageName='Заменить ip';
				break;
			case 2:
				$obj->pageName='Очистить кэш';
				break;
			case 3:
				$obj->pageName='Прервать соединение соединение';
				break;
		}

	}
};
echo json_encode($obj);