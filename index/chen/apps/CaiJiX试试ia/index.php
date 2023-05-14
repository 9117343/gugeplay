<?php

/**
 * @version    $Id update.php 1001 2011-9-13 qjp $
 * @copyright  Copyright (c) 2010-2011,qjp
 * @license    This is NOT a freeware, use is subject to license terms
 * @link       http://www.qjp.name
 */

require dirname(__FILE__)."/../../config.php";

if(empty($dopost)){
    showmsg("正在升级，请稍后","?dopost=step1");
    exit;
}

if($dopost == 'step1'){
    $sql = array();
    $sql[] = "ALTER TABLE `#@__kwcache` CHANGE `typeid` `nid` SMALLINT(5) UNSIGNED NOT NULL";
    $sql[] = "ALTER TABLE `#@__kwkeyword` ADD `type` TINYINT(1) UNSIGNED NOT NULL AFTER `keyword` ";
    $sql[] = "DELETE FROM `#@__plugins_config` WHERE `name`='kw_weight' ";
    $sql[] = "INSERT INTO `#@__plugins_config` (`name` ,`value`) VALUES ('kw_egapi', 'bd'),('kw_ttf', '1')";
    $sql[] = "DELETE FROM `#@__kwkeyword` WHERE `keyword` LIKE '%regex%' ";
    $sql[] = "DELETE FROM `#@__sys_module` WHERE `hashcode`='d7facbd1cf9979ae352bb8fe175bc59f' ";
    $sql[] = "INSERT INTO `#@__sys_module` (`hashcode`, `modname`, `indexname`, `indexurl`, `ismember`, `menustring`) VALUES
('d7facbd1cf9979ae352bb8fe175bc59f', '织梦采集侠v2.50', '', '', 0, '<m:top name=''织梦采集侠'' c=''1,'' display=''block'' rank=''''>\r\n<m:item name=''基本设置'' link=''cjx.php?ac=setting'' rank='''' target=''main'' />\r\n<m:item name=''高级设置'' link=''cjx.php?ac=advanced'' rank='''' target=''main'' />\r\n<m:item name=''伪原创设置'' link=''cjx.php?ac=seo'' rank='''' target=''main'' />\r\n<m:item name=''搜索优化设置'' link=''cjx.php?ac=search'' rank='''' target=''main'' />\r\n<m:item name=''采集任务'' link=''cjx.php?ac=task'' rank='''' target=''main'' />\r\n<m:item name=''会员系统'' link=''cjx.php?ac=credits'' rank='''' target=''main'' />\r\n<m:item name=''插件更新'' link=''cjx.php?ac=update'' rank='''' target=''main'' />\r\n<m:item name=''帮助中心'' link=''http://www.dedeapps.com/Related/?plugin=caijixia'' rank='''' target=''main'' />\r\n</m:top>');";

    foreach($sql as $s){
        $dsql -> ExecuteNoneQuery($s);
    }
    
    $dsql->SetQuery("SELECT * FROM `#@__kwkeyword` WHERE `keyword` LIKE '%rss%' ");
    $dsql->Execute();
    while($arr = $dsql->GetArray()){
        $tmp = str_replace(array('<rss>','</rss>'),'', $arr['keyword']);
        $dsql -> ExecuteNoneQuery("UPDATE `#@__kwkeyword` SET `keyword`='{$tmp}',`type`=1 WHERE nid={$arr['nid']}");
    }

    UpdateConfig();

    unlink(dirname(__FILE__)."/index.php");

    $rflwft = "<script language='javascript' type='text/javascript'>\r\n";
    $rflwft .= "if(window.navigator.userAgent.indexOf('MSIE')>=1) top.document.frames.menu.location = '../../index_menu_module.php';\r\n";
    $rflwft .= "else top.document.getElementById('menu').src = 'index_menu_module.php';\r\n";
    $rflwft .= "</script>";
    echo $rflwft;
    showmsg("升级完成，请刷新后台",1,2);
    
    exit;
}

function UpdateConfig()
{
    global $dsql;
	if($fp = fopen(DEDEDATA.'/Plugins.config.inc.php','w'))
	{	
		flock($fp,3);
		fwrite($fp,"<"."?php\r\n");
		$dsql->SetQuery("Select * From `#@__plugins_config` order by id asc ");
		$dsql->Execute();
		while($row = $dsql->GetArray())
		{
			if(is_numeric($row['value']))
				fwrite($fp,"\${$row['name']} = ".$row['value'].";\r\n");
			else
				fwrite($fp,"\${$row['name']} = '".str_replace("'","\\'",stripslashes($row['value']))."';\r\n");
		}
		fwrite($fp,"?".">");
		fclose($fp);
	}else
	{
		ShowMsg('写入失败！请设置'.DEDEDATA.'/Plugins.config.inc.php'.'可写权限',-1);
		exit();
	}
}

?>