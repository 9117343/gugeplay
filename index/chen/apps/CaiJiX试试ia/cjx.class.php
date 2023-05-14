<?php
/**
 *
 * @name           caijixia for dedecms
 * @version        V2.5 2011��8��15�� 23:00 qjpemail $
 * @copyright      Copyright (c) 2011��caijixia for dedecms��caijixia.com.
 * @license        This is NOT a freeware, use is subject to license terms
 */

require_once DEDEINC.'/dedehttpdown.class.php';
require_once DEDEINC.'/dedehtml2.class.php';
require_once DEDEINC."/oxwindow.class.php";

class admin_cjx
{
	var $db;
	var $cjxfile;
	var $configfile;
    var $ver = '2.551';
    
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function __construct()
	{
		$this->db = $this->gv('db');
		$this->configfile = DEDEDATA.'/Plugins.config.inc.php';
		$this->cjxfile = DEDEDATA.'/admin/kw.txt';
		$this->assign('cjxhost',$this->gv('cmsurl'));
		if(preg_match('/57/',$this->gv('version')))
		{
			$this->assign('css','css');
			$this->assign('img','images');
		}else
		{
			$this->assign('css','img');
			$this->assign('img','img');
		}
	}

	function admin_cjx()
	{
		$this->	__construct();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function ac_setting()
	{
		$this->display();	
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_advanced()
	{
		$this->display();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_seo()
	{
		$this->display();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_search()
	{
		$this->display();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_savesetting()
	{
		$setting = $this->gv('setting');
        $this->autoch($setting);
		foreach($setting as $k=>$v){
            cjxdb('plugins_config')->where("name='$k'")->update(array('value'=>stripslashes($v)));
		}
		$this->UpdateConfig();
		ShowMsg("����ɹ���","-1",0,1000);
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_credits()
	{
        global $cfg_basehost;
		header("Location:http://www.dedeapps.com/Credits?domain=".str_replace('http://','',$cfg_basehost));		
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function ac_task()
	{
        require_once(DEDEINC."/dedetag.class.php");
        $dtp = new DedeTagParse();
        $rs = cjxdb('arctype')->where(array('ispart'=>0,'channeltype'=>1))->order('sortrank asc')->fields('id,typename')->select();
		foreach($rs as $k => $v){
            $rs[$k]['keyword'] = ''; $rs[$k]['close'] = 0;
            $tmp = cjxdb('kwkeyword')->where("typeid={$v['id']}")->order("`type` asc")->select();
            if($tmp){
                foreach($tmp as $v){
                    if($v['type']==0){
                        $rs[$k]['keyword'] .= empty($rs[$k]['keyword'])?$v['keyword']:','.$v['keyword'];
                    }else if($v['type']==1){
                        $rs[$k]['keyword'] .= '<br>RSS:'.$v['keyword'];
                    }else if($v['type']==2){
                        $dtp->LoadString($v['keyword']);
                        $v['keyword'] = $dtp->GetTagByName('list')?$dtp->GetTagByName('list')->GetInnerText():'';
                        $rs[$k]['keyword'] .= '<br>����'.$v['keyword'];
                    }else{
                        if(!isset($bang)){
                            $rs[$k]['keyword'] .= '<br>�󶨽ڵ㣺'.$v['keyword'];
                            $bang = true;
                        }else{
                            $rs[$k]['keyword'] .= '��'.$v['keyword'];
                        }
                    }
                    $rs[$k]['close'] = $v['isclose'];
                }
            }
		}

		$this->assign('kwtype',$rs);
        $rs = cjxdb('plugins_config')->where("name='kw_cron'")->Fields('value')->find();
		$arr = explode(',',$rs['value']);
        $cron = array();
		foreach($arr as $v) $cron[$v] = true;
		$this->assign('cron',$cron);
		$this->display();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_cjxfile()
	{
		file_put_contents($this->cjxfile,$this->gv('value'));
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_gettask()
	{
		AjaxHead();
		$typeid = $this->gv('typeid');
        $rs = cjxdb('kwkeyword')->where("typeid=$typeid")->Fields('`type`,`keyword`')->select();
        $keyword = $rss = $dx = $dxs = '';
        require_once(DEDEINC."/dedetag.class.php");
        $dtp = new DedeTagParse();
        foreach($rs as $r){
            if($r['type']==0){
                $keyword .= empty($keyword)?$r['keyword']:"\r\n".$r['keyword'];
            }else if($r['type']==1){
                $rss .= empty($rss)?$r['keyword']:"\r\n".$r['keyword'];
            }else if($r['type']==2){
                $dx .= empty($dx)?$r['keyword']:"``".$r['keyword'];
                $dtp->LoadString($r['keyword']);
                $dxt = $dtp->GetTagByName('list')?$dtp->GetTagByName('list')->GetInnerText():'';
                $dxs .= "<span><a href='javascript:void(0);' style='float:right' onclick='delpage(this);'>ɾ��</a><a href='javascript:void(0);' style='float:right' onclick='editpage(this);'>�༭&nbsp;</a>".$dxt."</span>";
            }else{
                
            }
        }

        $note = cjxdb('co_note')->Fields('nid,notename')->where('channelid=1')->select();
        foreach($note as $k => $v){
            $ck = cjxdb('kwkeyword')->where("`keyword`={$v['nid']} AND `type`=3")->find();
            if($ck){
                if($ck['typeid']==$typeid){
                    $note[$k]['btype'] = true;
                }else{
                    $note[$k]['btype'] = $ck['typeid'];
                }
            }
            $note[$k]['channelname'] = '��ͨ����';
        }

        $this->assign('typeid',$typeid);
        $this->assign('keyword',$keyword);
        $this->assign('rss',$rss);
        $this->assign('dx',$dx);
        $this->assign('dxs',$dxs);
        $this->assign('notelist',$note);
        $this->display();
	}

    function ac_edittask(){
        global $cfg_soft_lang;
        $data = stripslashes($this->GV('data'));
        if($cfg_soft_lang!='utf-8'){
            $data = utf82gb($data);
        }
        require_once DEDEINC.'/dedetag.class.php';
        $this->dtp = new DedeTagParse();
        $this->dtp->LoadString($data);
        $r = array();
        foreach($this->dtp->CTags as $ctag){
            $itemName = $ctag->TagName;
            $r[$itemName] = trim($ctag->InnerText);
        }
        $this->assign('olddata',$data);
        $this->assign('r',$r);
        $this->display();
    }


	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
     
    function ac_bindtype(){
        $typeid = $this->gv('typeid');
        $nid = $this->gv('nid');
        cjxdb('kwkeyword')->insert(array('typeid'=>$typeid,'keyword'=>$nid,'type'=>3));
    }
    
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
     
    function ac_unbindtype(){
        $typeid = $this->gv('typeid');
        $nid = $this->gv('nid');
        cjxdb('kwkeyword')->where(array('typeid'=>$typeid,'keyword'=>$nid,'type'=>3))->delete();
    }

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_saveword()
	{
        $keyword = $this->gv('keyword');
        $this->autoch($keyword);
        $typeid = $this->gv('typeid');
        $m = $this->gv('m');
        foreach($keyword as $k => $r){
            if($k==2){
                $ass = explode("``",$r);
            }else{
                $r = str_replace("\r","\n",$r);
                $ass = explode("\n",$r);
            }

            $ass = array_filter($ass);
            
            $adds = '';
            foreach($ass as $_r){
                $adds .= " AND `keyword` not like '$_r'";
            }
            cjxdb("kwkeyword")->where("`typeid`=$typeid AND `type`=$k $adds")->delete();
            
    		foreach($ass as $w){
                if($m-- <= 0) break;
    			if(!empty($w)){
                    $chk = cjxdb('kwkeyword')->where(" typeid=$typeid AND keyword='$w' ")->find();
                    if(empty($chk)){
                        $w = stripslashes($w);
                        cjxdb('kwkeyword')->insert(array('typeid'=>$typeid,'keyword'=>$w,'type'=>$k));
                    }
    			}
    		}
        }
        print 'success';
	}

    function autoch(&$data){
        if($this->gv('soft_lang')=='utf-8') return $data;
        foreach($data as $k => $v){
            if(is_array($v)){
                $data[$k] = $this->autoch($v);
            }else{
                $data[$k] = utf82gb($v);
            }
        }
        return $data;
    }

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_status()
	{
        $tid = $this->gv('tid');
		$do = ($this->gv('type')+1)%2;
        if(empty($tid)){
            showmsg('��ѡ����Ŀ','?ac=task');
            exit;
        }
		if(is_array($tid)) $tid = join(',',$tid);
        $rs = cjxdb('kwkeyword')->where("typeid in ($tid) ")->update(array('isclose'=>$do));
		Showmsg('�޸ĳɹ������ڷ���','?ac=task');
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */	
    function ac_clearall()
	{
        cjxdb('kwkeyword')->delete();
        showmsg('�ɹ����������Ŀ�ɼ���Ŀ','?ac=task');
	}
	
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function ac_cron()
	{
		$cron = $this->gv('cron');
		$data = '';
		if($cron) $data = join(',',$cron);
        cjxdb('plugins_config')->where("`name`='kw_cron'")->update(array('value'=>$data));
		$this->UpdateConfig();
		Showmsg('����ɹ������ڷ���','?ac=task');
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function ac_runnow()
	{
		$this->display();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
	 
     function ac_testregx()
     {
        global $cfg_soft_lang;
        $data = stripslashes($this->GV('data'));
        if($cfg_soft_lang!='utf-8'){
            $data = utf82gb($data);
        }
        require_once DEDEINC.'/dedetag.class.php';
        $this->dtp = new DedeTagParse();
        $this->dtp->LoadString($data);
        foreach($this->dtp->CTags as $ctag){
            $itemName = $ctag->TagName;
            $$itemName = trim($ctag->InnerText);
        }
        if(empty($list) || empty($page) || $list=='http://' || $page=='http://') exit('�������');
        $listarr = array();
        if(preg_match("/\[([0-9]*-[0-9]*)\]/",$list,$out)){
            list($min,$max) = explode('-',$out[1]);
            if($max-$min>10) $max = $min+9;
            for($i=$min;$i<=$max;$i++){
                $listarr[] = preg_replace("/\[([0-9]*-[0-9]*)\]/",$i,$list);
            }
            $list = preg_replace("/\[([0-9]*-[0-9]*)\]/",$min,$list);
        }else{
            $listarr[] = $list;
        }
        $str = $this->downfile($list);
        if($cfg_soft_lang!=$charset){
            if($charset=='utf-8')
            {
                $str = utf82gb($str);
            }else
            {
                $str = gb2utf8($str);
            }
        }
        $page = str_replace('(*)','###',$page);
        $page = preg_quote($page,'/');
        $page = str_replace('###','([0-9a-zA-Z\.\-\/]*)',$page);
        $dhtml = new DedeHtml2();
        $dhtml->SetSource($str,$list,'link');
        $lss = array();
        $i = 0;
        foreach($dhtml->Links as $s){
            if(preg_match('/'.$page.'/iU',$s['link'])){
                if(!isset($lss[$s['link']])){
                    if(!isset($first)) $first = $s['link'];
                    $lss[$s['link']] = $s['link'];
                    $i++;
                    if($i==10) break;
                }
            }
        }
        $msg = '';
        $GLOBALS['wintitle'] = "�ɼ���-���Զ���ɼ�����";
        $GLOBALS['wecome_info'] = "�ɼ�������ɼ�::�ɼ��������";
        $win = new OxWindow();
        $win->AddTitle('ƥ�䵽���б��ַ��ǰ10����');
        foreach($listarr as $v){
            $msg .= $v."<br>";
        }
        $win->AddMsgItem($msg);
        $win->AddTitle('��һ���б�ҳƥ�䵽�����µ�ַ��ǰ10����');
        $msg = '';
        foreach($lss as $v){
            $msg .= $v."<br>";
        }
        $win->AddMsgItem($msg);
        
        $str = $this->downfile($first);
        if($cfg_soft_lang!=$charset){
            if($charset=='utf-8') {
                $str = utf82gb($str);
            }else{
                $str = gb2utf8($str);
            }
        }

        $win->AddTitle("<font color=black>���Բɼ���һƪ����:$first </font>");
        $win->AddTitle('���±���');
        if(empty($titlerule)){
            $win->AddMsgItem('�Զ�������Ҫ����');
        }else{
            $win->AddMsgItem($this->UT($str,$titlerule));
        }
        
        $win->AddTitle('����');
        if(empty($authorrule)){
            $win->AddMsgItem('�Զ�������Ҫ����');
        }else{
            $win->AddMsgItem($this->UT($str,$authorrule));
        }
        
        $win->AddTitle('��Դ');
        if(empty($sourcerule)){
            $win->AddMsgItem('�Զ�������Ҫ����');
        }else{
            $win->AddMsgItem($this->UT($str,$sourcerule));
        }
        
        $win->AddTitle('�������ݣ������޷��ɼ���ҳ���ݣ�');
        if(empty($bodyrule)){
            $win->AddMsgItem('�Զ�������Ҫ����');
        }else{
            $win->AddMsgItem($this->UT($str,$bodyrule));
        }
        
        $win->AddTitle('��ҳ����');
        if(empty($fyrule)){
            $win->AddMsgItem('�Զ��ɼ���ҳ����Ҫ����');
        }else{
            $fylink = $this->UT($str,$fyrule);
            $dhtml = new DedeHtml2();
            $dhtml->SetSource($fylink,$first,'link');
            $relink = '';
            foreach($dhtml->Links as $k=>$v){
                $relink .= $k."<br>";
            }
            $win->AddMsgItem($relink);
        }
        
        $GLOBALS['winform'] = $win->GetWindow("hand");
        $win->Display();
    }
    
    function UT($data,$r){
        list($a,$b) = explode('[����]',$r);
        $tmp = explode($a,$data);
        if(isset($tmp[1])) $tmp2 = explode($b,$tmp[1]);
        return isset($tmp2[0])?$tmp2[0]:'';
    }
    
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

    function ac_testhttp()
    {
        $s = $this->downfile("http://www.dedeapps.com/?m=Caijixia&a=testhttp");
        if($s=='success')
        {
            ShowMsg('���Ŀռ�֧�ֲɼ�',-1);
        }else
        {
            Showmsg('ϵͳ��⵽���Ŀռ���ܲ�֧�ֲɼ�',1,2);
        }
    }
    
    function ac_delcache(){
        cjxdb('kwcache')->delete();
        ShowMsg('��������ɹ�',-1);
    }
    
    function ac_delhash(){
        cjxdb('kwhash')->delete();
        ShowMsg('��ʷ��¼����ɹ�',-1);
    }
    
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
     
     function ac_update()
     {
        $str = $this->downfile('http://www.dedeapps.com/Update/?type=2&plugin=kwrobot&ver='.$this->ver);
        if($this->gv('soft_lang')!='utf-8') $str = utf82gb($str);
        list($ver,$msg) = explode('|',$str);
        if($this->ver==$ver || $ver == 'error')
        {
            ShowMsg($msg,1,2);
        }else
        {
            ShowMsg($msg."<br><a href='?ac=updatenow&ver={$ver}'>���������������</a>",'index.php',0,1000*60*5);
        }
     }
	 
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
     
     function ac_updatenow()
     {
         require_once DEDEINC."/dedemodule.class.php";
         $mdir = DEDEDATA.'/module';
         $ver = $this->gv('ver');
         $file = $this->downfile('http://www.dedeapps.com/uploads/onlineupdate/'.$ver.'_'.$this->gv('soft_lang').'.xml');
         file_put_contents($mdir.'/cjxupdate.xml',$file);
         $dm = new DedeModule($mdir);
         $infos = $dm->GetModuleInfo($mdir.'/cjxupdate.xml','file');
         if(empty($infos['hash']))
         {
             ShowMsg('����ʧ��',1,2);exit;
         }
         copy($mdir.'/cjxupdate.xml',$mdir.'/'.$infos['hash'].'.xml');
         $dm->WriteFiles($infos['hash'],1);
         @unlink($mdir.'/cjxupdate.xml');
         @unlink($mdir.'/'.$infos['hash'].'.xml');
         ShowMsg('�������',1,2);
     }
     
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
     
     function ac_cjxshow()
     {
		 if(is_file($this->cjxfile)) print file_get_contents($this->cjxfile);
     }
	 
	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	 function ac_suggest()
	 {
        $content = Html2Text($this->gv('v'));
		$url = 'http://www.dedeapps.com/Suggest?';
		$query_str = "type=caijixia&content=".$content;
        $context =
        array('http' =>
                array('method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded'."\r\n".
                                'User-Agent: Mozilla-cjx-u-api-cli (non-curl) '.phpversion()."\r\n".
                                'Content-length: ' . strlen($query_str),
                    'content' => $query_str));
        $contextid = stream_context_create($context);
        $sock = fopen($url, 'r', FALSE, $contextid);
        if ($sock)
        {
            $result = '';
            while (!feof($sock))
            {
                $result .= fgets($sock, 4096);
            }
            fclose($sock);
        }
        print '�ύ�ɹ�����л���Ľ���';
	 }

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function display()
	{
		if(!file_exists($this->configfile)){
			$this->UpdateConfig();
		}
        $rs = cjxdb('plugins_config')->select();
        foreach($rs as $v){
            $$v['name'] = $v['value'];
        }
		@extract($GLOBALS['_cjx']);
		require $this->tpl();
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function gv($k)
	{
		if(isset($GLOBALS[$k]))
			return $GLOBALS[$k];
		else if(isset($GLOBALS['kw_'.$k]))
			return $GLOBALS['kw_'.$k];
		else if(isset($GLOBALS['cfg_'.$k]))
			return $GLOBALS['cfg_'.$k];
		else 
			return false;
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function tpl($template = '')
	{
		$name = $template==''?$this->gv('ac'):$template;
		$templets = DEDEADMIN.'/apps/CaiJiXia/templets/'.$name.'.htm';
		if(is_file($templets)) return $templets;
		else Showmsg("ģ��{$templets}������",1,2);exit;
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
    function assign($k, $v)
    {
        $GLOBALS['_cjx'][$k] = $v;
    }

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */
 
	function UpdateConfig()
	{
		if($fp = fopen($this->configfile,'w'))
		{	
			flock($fp,3);
			fwrite($fp,"<"."?php\r\n");
            $rs = cjxdb('plugins_config')->order('id asc')->select();
            foreach($rs as $row){
				if(is_numeric($row['value']))
					fwrite($fp,"\${$row['name']} = ".$row['value'].";\r\n");
				else
					fwrite($fp,"\${$row['name']} = '".str_replace("'","\\'",stripslashes($row['value']))."';\r\n");
            }
			fwrite($fp,"?".">");
			fclose($fp);
		}else
		{
			ShowMsg('д��ʧ�ܣ�������'.$this->configfile.'��дȨ��',-1);
			exit();
		}
	}

	/**
	 * caijixia for dedecms
	 * @version   V2.5 2011��8��15�� 23:00 qjpemail $
	 * @copyright Copyright (c) 2011��caijixia for dedecms��caijixia.com.
	 * @license   This is NOT a freeware, use is subject to license terms
	 *
	 * @param     NULL
	 * @return    NULL
	 */

	function downfile($s)
	{
        $c = '';
        $useragent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2)';
        if(function_exists('fsockopen')){
      		$httpdown = new DedeHttpDown();
    		$httpdown->OpenUrl($s);
    		$c = $httpdown->GetHtml();
    		$httpdown->Close(); 
        }else if(function_exists('curl_init') && function_exists('curl_exec')){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $s);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
            $c = curl_exec($ch);
            curl_close($ch);
        }
        if(empty($c) && ini_get('allow_url_fopen')){
            $c = file_get_contents($s);
        }else if(empty($c) && function_exists('pfsockopen')){
            exit('ϵͳ�޷��ɼ�����ͼ�����ϵ��');
        }
		return $c;
	}
}
?>