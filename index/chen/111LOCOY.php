<?php
//�±��ǵ�½��Ϣ,��ʹ�����Լ����ʺź�����
$userid='chenxp';
$pwd='a1111111';
//require_once(dirname(__FILE__)."/config.php");
//���°���config.php

define('DEDEADMIN', ereg_replace("[/\\]{1,}",'/',dirname(__FILE__) ) );
require_once(DEDEADMIN."/../include/common.inc.php");
require_once(DEDEINC."/userlogin.class.php");
header("Cache-Control:private");
$dsql->safeCheck = false;

//��õ�ǰ�ű����ƣ�������ϵͳ��������$_SERVER�����������и������ѡ��
$dedeNowurl = $s_scriptName = '';
$isUrlOpen = @ini_get("allow_url_fopen");
$dedeNowurl = GetCurUrl();
$dedeNowurls = explode('?',$dedeNowurl);
$s_scriptName = $dedeNowurls[0];

//�����û���¼״̬
//$cuserLogin = new userLogin();
/*ע�͵��û���½��Ϣ
if($cuserLogin->getUserID()==-1)
{
	header("location:login.php?gotopage=".urlencode($dedeNowurl));
	exit();
}
*/

	//�Զ����ӵ�½
	 $cuserLogin = new userLogin();
	 if(!empty($userid)&&!empty($pwd))
	 {
		  $res = $cuserLogin->checkUser($userid,$pwd);
		  //�ɹ���¼
		  if($res==1){
			   $cuserLogin->keepUser();
		  }
		  else if($res==-1){
			ShowMsg("����û���������!","-1");exit(); 
		  }
		  else{
			ShowMsg("����������!","-1");exit(); 
		  }
	 }//<-���벻Ϊ��
	 else{
			ShowMsg("�û�������û��д����!","-1");exit();
	 }

	 //��½��Ϣ����
if($cfg_dede_log=='Y')
{
	$s_nologfile = "_main|_list";
	$s_needlogfile = "sys_|file_";
	$s_method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : "";
	$s_query = isset($dedeNowurls[1]) ? $dedeNowurls[1] : "";
	$s_scriptNames = explode('/',$s_scriptName);
	$s_scriptNames = $s_scriptNames[count($s_scriptNames)-1];
	$s_userip = GetIP();
	if( $s_method=='POST' || (!eregi($s_nologfile,$s_scriptNames) && $s_query!='') || eregi($s_needlogfile,$s_scriptNames) )
	{
		$inquery = "INSERT INTO `#@__log`(adminid,filename,method,query,cip,dtime)
             VALUES ('".$cuserLogin->getUserID()."','{$s_scriptNames}','{$s_method}','".addslashes($s_query)."','{$s_userip}','".time()."');";
		$dsql->ExecuteNoneQuery($inquery);
	}
}
$cache1 = DEDEDATA."/cache/inc_catalog_base.inc";
if(!file_exists($cache1))
{
	UpDateCatCache();
}

//������Ŀ����
function UpDateCatCache()
{
	global $dsql,$cfg_multi_site;
	$cache1 = DEDEDATA."/cache/inc_catalog_base.inc";
	$dsql->SetQuery("Select id,reid,channeltype,issend From `#@__arctype`");
	$dsql->Execute();
	$fp1 = fopen($cache1,'w');
	$phph = '?';
	$fp1Header = "<{$phph}php\r\nglobal \$_Cs;\r\n\$_Cs=array();\r\n";
	fwrite($fp1,$fp1Header);
	while($row=$dsql->GetObject())
	{
		fwrite($fp1,"\$_Cs[{$row->id}]=array({$row->reid},{$row->channeltype},{$row->issend});\r\n");
	}
	fwrite($fp1,"{$phph}>");
	fclose($fp1);
}

function DedeInclude($filename,$isabs=false)
{
	return $isabs ? $filename : DEDEADMIN.'/'.$filename;
}

//���ϰ���config.php

CheckPurview('a_New,a_AccNew');
require_once(DEDEINC.'/customfields.func.php');
require_once(DEDEADMIN.'/inc/inc_archives_functions.php');
if(file_exists(DEDEDATA.'/template.rand.php'))
{
	require_once(DEDEDATA.'/template.rand.php');
}
if(empty($dopost))
{
	$dopost = '';
}

if($dopost!='save')
{
	require_once(DEDEINC."/dedetag.class.php");
	require_once(DEDEADMIN."/inc/inc_catalog_options.php");
	ClearMyAddon();
	$channelid = empty($channelid) ? 0 : intval($channelid);
	$cid = empty($cid) ? 0 : intval($cid);

	if(empty($geturl)) $geturl = '';
	
	$keywords = $writer = $source = $body = $description = $title = '';

	//�ɼ�������ҳ
	if(ereg('^http://',$geturl))
	{
		require_once(DEDEADMIN."/inc/inc_coonepage.php");
		$redatas = CoOnePage($geturl);
		extract($redatas);
	}

	//���Ƶ��ģ��ID
	if($cid>0 && $channelid==0)
	{
		$row = $dsql->GetOne("Select channeltype From `#@__arctype` where id='$cid'; ");
		$channelid = $row['channeltype'];
	}
	else
	{
		if($channelid==0)
		{
			$channelid = 1;
		}
	}

	//���Ƶ��ģ����Ϣ
	$cInfos = $dsql->GetOne(" Select * From  `#@__channeltype` where id='$channelid' ");
	include DedeInclude("templets/article_add.htm");
	exit();
}

/*--------------------------------
function __save(){  }
-------------------------------*/
else if($dopost=='save')
{
	require_once(DEDEINC.'/image.func.php');
	require_once(DEDEINC.'/oxwindow.class.php');
	$flag = isset($flags) ? join(',',$flags) : '';
	$notpost = isset($notpost) && $notpost == 1 ? 1: 0;
	
	if(empty($typeid2)) $typeid2 = '';
	if(!isset($autokey)) $autokey = 0;
	if(!isset($remote)) $remote = 0;
	if(!isset($dellink)) $dellink = 0;
	if(!isset($autolitpic)) $autolitpic = 0;
	if(empty($click)) $click = ($cfg_arc_click=='-1' ? mt_rand(50, 200) : $cfg_arc_click);
	
	if(empty($typeid))
	{
		ShowMsg("��ָ���ĵ�����Ŀ��","-1");
		exit();
	}
	if(empty($channelid))
	{
		ShowMsg("�ĵ�Ϊ��ָ�������ͣ������㷢�����ݵı��Ƿ�Ϸ���","-1");
		exit();
	}
	if(!CheckChannel($typeid,$channelid))
	{
		ShowMsg("����ѡ�����Ŀ�뵱ǰģ�Ͳ��������ѡ���ɫ��ѡ�","-1");
		exit();
	}
	if(!TestPurview('a_New'))
	{
		CheckCatalog($typeid,"�Բ�����û�в�����Ŀ {$typeid} ��Ȩ�ޣ�");
	}

	//�Ա�������ݽ��д���
	if(empty($writer))$writer=$cuserLogin->getUserName();
	if(empty($source))$source='δ֪';
	$pubdate = GetMkTime($pubdate);
	$senddate = time();
	$sortrank = AddDay($pubdate,$sortup);
	$ismake = $ishtml==0 ? -1 : 0;
	$title = ereg_replace('"', '��', $title);
	$title = htmlspecialchars(cn_substrR($title,$cfg_title_maxlen));
	$shorttitle = cn_substrR($shorttitle,36);
	$color =  cn_substrR($color,7);
	$writer =  cn_substrR($writer,100);
	$source = cn_substrR($source,100);
	$description = cn_substrR($description,$cfg_auot_description);
	$keywords = cn_substrR($keywords,60);
	$filename = trim(cn_substrR($filename,40));
	$userip = GetIP();

	if(!TestPurview('a_Check,a_AccCheck,a_MyCheck'))
	{
		$arcrank = -1;
	}
	$adminid = $cuserLogin->getUserID();

	//�����ϴ�������ͼ
	if(empty($ddisremote))
	{
		$ddisremote = 0;
	}
	
	$litpic = GetDDImage('none', $picname, $ddisremote);

	//�����ĵ�ID
	$arcID = GetIndexKey($arcrank,$typeid,$sortrank,$channelid,$senddate,$adminid);
    
	if(empty($arcID))
	{
		ShowMsg("�޷��������������޷����к���������","-1");
		exit();
	}
	if(trim($title) == '')
	{
		ShowMsg('���ⲻ��Ϊ��', '-1');
		exit();
	}

	//����body�ֶ��Զ�ժҪ���Զ���ȡ����ͼ��
	$body = AnalyseHtmlBody($body,$description,$litpic,$keywords,'htmltext');

	//�Զ���ҳ
	if($sptype=='auto')
	{
		$body = SpLongBody($body,$spsize*1024,"#p#��ҳ����#e#");
	}

	//���������ӱ�����
	$inadd_f = $inadd_v = '';
	if(!empty($dede_addonfields))
	{
		$addonfields = explode(';',$dede_addonfields);
		if(is_array($addonfields))
		{
			foreach($addonfields as $v)
			{
				if($v=='') continue;
				$vs = explode(',',$v);
				if($vs[1]=='htmltext'||$vs[1]=='textdata')
				{
					${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$litpic,$keywords,$vs[1]);
				}
				else
				{
					if(!isset(${$vs[0]})) ${$vs[0]} = '';
					${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$arcID);
				}
				$inadd_f .= ','.$vs[0];
				$inadd_v .= " ,'".${$vs[0]}."' ";
			}
		}
	}

	//����ͼƬ�ĵ����Զ�������
	if($litpic!='' && !ereg('p',$flag))
	{
		$flag = ($flag=='' ? 'p' : $flag.',p');
	}
	if($redirecturl!='' && !ereg('j',$flag))
	{
		$flag = ($flag=='' ? 'j' : $flag.',j');
	}
	
	//��ת��ַ���ĵ�ǿ��Ϊ��̬
	if(ereg('j', $flag)) $ismake = -1;

	//���浽����
	$query = "INSERT INTO `#@__archives`(id,typeid,typeid2,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
    color,writer,source,litpic,pubdate,senddate,mid,notpost,description,keywords,filename,dutyadmin)
    VALUES ('$arcID','$typeid','$typeid2','$sortrank','$flag','$ismake','$channelid','$arcrank','$click','$money',
    '$title','$shorttitle','$color','$writer','$source','$litpic','$pubdate','$senddate',
    '$adminid','$notpost','$description','$keywords','$filename','$adminid');";

	if(!$dsql->ExecuteNoneQuery($query))
	{
		$gerr = $dsql->GetError();
		$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
		ShowMsg("�����ݱ��浽���ݿ����� `#@__archives` ʱ������������Ϣ�ύ��DedeCms�ٷ���".str_replace('"','',$gerr),"javascript:;");
		exit();
	}

	//���浽���ӱ�
	$cts = $dsql->GetOne("Select addtable From `#@__channeltype` where id='$channelid' ");
	$addtable = trim($cts['addtable']);
	if(empty($addtable))
	{
		$dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
		$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
		ShowMsg("û�ҵ���ǰģ��[{$channelid}]��������Ϣ���޷���ɲ�������","javascript:;");
		exit();
	}
	$useip = GetIP();
	$templet = empty($templet) ? '' : $templet;
	$query = "INSERT INTO `{$addtable}`(aid,typeid,redirecturl,templet,userip,body{$inadd_f}) Values('$arcID','$typeid','$redirecturl','$templet','$useip','$body'{$inadd_v})";
	if(!$dsql->ExecuteNoneQuery($query))
	{
		$gerr = $dsql->GetError();
		$dsql->ExecuteNoneQuery("Delete From `#@__archives` where id='$arcID'");
		$dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID'");
		ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� `{$addtable}` ʱ������������Ϣ�ύ��DedeCms�ٷ���".str_replace('"','',$gerr),"javascript:;");
		exit();
	}

	//����HTML
	InsertTags($tags,$arcID);
	$artUrl = MakeArt($arcID,true,true);
	if($artUrl=='')
	{
		$artUrl = $cfg_phpurl."/view.php?aid=$arcID";
	}
	ClearMyAddon($arcID, $title);
	//���سɹ���Ϣ
	$msg = "    ������ѡ����ĺ���������
    <a href='article_add.php?cid=$typeid'><u>������������</u></a>
    &nbsp;&nbsp;
    <a href='$artUrl' target='_blank'><u>�鿴����</u></a>
    &nbsp;&nbsp;
    <a href='archives_do.php?aid=".$arcID."&dopost=editArchives'><u>��������</u></a>
    &nbsp;&nbsp;
    <a href='catalog_do.php?cid=$typeid&dopost=listArchives'><u>�ѷ������¹���</u></a>
    &nbsp;&nbsp;
    $backurl
  ";
  $msg = "<div style=\"line-height:36px;height:36px\">{$msg}</div>".GetUpdateTest();
	$wintitle = "�ɹ��������£�";
	$wecome_info = "���¹���::��������";
	$win = new OxWindow();
	$win->AddTitle("�ɹ��������£�");
	$win->AddMsgItem($msg);
	$winform = $win->GetWindow("hand","&nbsp;",false);
	$win->Display();
}

?>