<?php

/**
 *
 * @name           caijixia for dedecms
 * @version        V2.5 2011/09/01 00:00 qjpemai $
 * @copyright      Copyright (c) 2011��caijixia.com.
 * @license        This is NOT a freeware, use is subject to license terms
 */

if(!defined('DEDEINC'))
{
	exit("Request Error!");
}

@set_time_limit(30);
@ignore_user_abort(true);

/**
 * CaiJiXia for DeDecms
 * @version   V2.5 2011/09/01 00:00 qjpemai $
 * @copyright Copyright (c) 2011��caijixia.com.
 * @license   This is NOT a freeware, use is subject to license terms
 *
 * @param     NULL
 * @return    NULL
 */

class cjxdbclass{
    
    var $table,
        $where = '',
        $order = '',
        $fields = '*',
        $limit = '',
        $sql,
        $db;

    function __construct($table){
        global $dsql;
        $this->table = '#@__'.$table;
        $this->db = $dsql;
    }

    function dbclass($table){
        $this->__construct($table);
    }

    function find(){
        $this->sql = 'SELECT '.$this->fields.' FROM `'.$this->table.'`'.$this->where.$this->order;
        $rs = $this->db->GetOne($this->sql);
        return $rs;
    }

    function count(){
        $this->fields = "count({$this->fields}) as num";
        $rs = $this->find();
        return $rs['num'];
    }

    function select(){
        $this->sql = 'SELECT '.$this->fields.' FROM `'.$this->table.'`'.$this->where.$this->order.$this->limit;
        $datalist = array();
        $this->db->Execute('me',$this->sql);
        while($rs = $this->db->GetArray()){
            $datalist[] = $rs;
        }
        return $datalist;
    }

    function update($data){
        if(empty($this->where)) return false;
        $fields = $this->getfields();
        $udata = array();
        foreach($data as $k => $v){
            if(isset($fields[$k])){
                $udata[] = "`$k`='".addslashes($v)."'";
            }
        }
        $udata = join(',',$udata);
        $this->sql = 'UPDATE `'.$this->table.'` SET '.$udata.$this->where;
        return $this->db->ExecuteNoneQuery($this->sql);
    }

    function delete(){
        $this->sql = 'DELETE FROM `'.$this->table.'`'.$this->where;
        return $this->db->ExecuteNoneQuery($this->sql);
    }

    function insert($data,$returnid=false){
        $fields = $this->getfields();
        $field = $value = '';
        foreach($data as $k => $v){
            if(isset($fields[$k])){
                $field .= "`$k`,";
                $value .= "'".addslashes($v)."',";
            }
        }
        $this->sql = 'INSERT INTO'.' `'.$this->table.'` ('.trim($field,',').') VALUES ('.trim($value,',').')';
        $rs = $this->db->ExecuteNoneQuery($this->sql);
        return $returnid?$this->db->GetLastID():$rs;
    }

    function where($where){
        $this->where = ' WHERE '.(is_array($where)?$this->arr2sql($where):$where);
        return $this;
    }

    function order($order){
        $this->order = ' ORDER BY '.$order;
        return $this;
    }

    function fields($fields){
        $this->fields = $fields;
        return $this;
    }

    function limit($limit){
        $this->limit = ' LIMIT '.$limit;
        return $this;
    }

    function arr2sql($where){
        $sql = '';
        foreach ($where as $key=>$val){
            $val = addslashes($val);
            $sql .= $sql ? " AND `$key` = '$val' " : " `$key` = '$val'";
        }
        return $sql;
    }

    function getfields(){
        $this->db->Execute('me' , "SHOW COLUMNS FROM `{$this->table}`");
        while($r = $this->db->GetArray('me')){
            $fields[$r['Field']] = $r['Type'];
        }
        return $fields;
    }
}

function cjxdb($table){
    return new cjxdbclass($table);
}

class CaiJiXia
{
	var $cr;
	var $tl;
	var $rl;
	var $pc;
	var $db;
	var $aid;
	var $rs;
	var $nw;
	var $mx;
    var $dtp;
	var $html;
	var $vo = array();
    var $us = array();

	function __construct()
	{
		$this->tl = DEDEDATA.'/time.lock.inc';
		$this->rl = P_APPS.'/CaiJiXia/cjx_base_data.rule';
	}

    function CaiJiXia()
    {
        $this->__construct();
    }

	function BH()
	{
        if(!preg_match($this->DC('body'), $this->html, $t))	return false;
        $text = $t[1];
        if(substr_count($this->html,"\n")>2500 || substr_count($text,"\n")>1500 || substr_count($text,"<a")>500) return false;
        $l = 0;
        while($l!=strlen($text))
        {
        	$l = strlen($text);
        	foreach($this->DC('brule') as $v)
        		$text =	preg_replace($v[0],$v[1],$text);
        }
        return trim($text);
	}

	function BS($s)
	{
		$tp = $this->html = $this->HD($s);
		$rs = $this->BY();
		if($rs && $this->I1($this->GV('fy')))
		{
			$st[] = $rs;
			if($pg = $this->PG())
			{
				foreach($pg as $u)
					if($u!=$s){
						$this->html = $this->HD($u);
						if($rs = $this->BY()) $st[] = $rs;
					}
			}
		}
		$this->html = $tp;$tp=NULL;
		return isset($st)?join('',$st):$rs;
	}

	function BY()
	{
		$by = $this->HA();
		$total = count($by);
		$r = strlen(Html2Text($this->html));
		$w=0;
		foreach($by as $k => $v)
		{
            $text = Html2Text($v);
            $texttmp = str_replace(array('��','��','!','��'),',',$text);
            $texttmps = explode(',',$texttmp);
            $c = count($texttmps);
			$s = strlen($v);
			$l = strlen($text);
			$wgt0 = pow(1-abs($k/$total-1/2)-0.1,2);
			$wgt1 = $l/$s;
			$wgt2 = $l/$r;
			$wgt = $wgt0+$wgt1+$wgt2;
			if($c>5 && $wgt>1 && $wgt1>0.4 && $l>300 && $w<$wgt){
				$w = $wgt;$bk = $k;}
		}
		if(isset($bk)) return $this->LP($by[$bk]);
		else return false;
	}

	function CO()
	{
 	    if($this->GV('kw_arcrank')){
            $where = "(a.`ismake`='-10' OR a.`arcrank`='-1')";
 	    }else{
            $where = "a.`ismake`='-10'";
 	    }
		$this->arc = $this->db->GetOne("SELECT a.id,a.typeid,a.flag,a.title,a.keywords,a.litpic,d.body,a.ismake,a.arcrank FROM `#@__archives` a,`#@__addonarticle` d WHERE a.id=d.aid AND $where ORDER BY a.id ASC");
		return is_array($this->arc)?$this->arc:false;
	}

	function CR()
	{
		if($crd = $this->GV('cron'))
		{
			$cr = explode(',',$crd);
			$h = MyDate('H',$this->nw);
            $h = intval($h);
			if($cr && !in_array($h,$cr))
			{
				$this->MG('cr');
			}
		}
		return true;
	}

	function CS($v)
	{
		if(preg_match($this->DC('crule'),$v,$i) && in_array(strtolower($i[0]),$this->DC('allchr')))
			$charset = strtolower($i[0]);
		else 
		{
            $v = preg_replace('/0-9a-z\-_/i','',Html2Text($v));
			$v0 = substr($v,0,20);
            $v1 = substr($v,0,21);
            $v2 = substr($v,0,22);
			if(preg_match($this->DC('u8rule'), $v0)||preg_match($this->DC('u8rule'), $v1)||preg_match($this->DC('u8rule'), $v2)) $charset = 'utf-8';
			else if(preg_match($this->DC('gbrule'), $v0)||preg_match($this->DC('gbrule'), $v1)||preg_match($this->DC('gbrule'), $v2)) $charset = 'gb2312';
		}
		return isset($charset)?($charset=='utf-8'?$charset:'gb2312'):false;
	}

	function CT($v,$f,$c)
	{
		if($f==$c) return $v;
		if($f[0]=='g') return gb2utf8($v);
		else return utf82gb($v);
	}

	function CU($r)
	{
		$r = $this->FA($this->FT($r));
		$r = $this->VL($this->VB($this->VP($r)));
		$r = $this->SB($this->IC($r));
        $ac1 = cjxdb('archives')->where("id={$r['id']}")->update($r);
        $ac2 = cjxdb('addonarticle')->where("aid={$r['id']}")->update($r);
        if($this->GV('ismake') && $this->GV('kw_arcrank')) $this->MA($r);
        else echo "�������� {$r['title']} ��ɣ�";
	}

	function DC($m,$arr=null)
	{
		if(empty($this->rs))
			$this->rs = $this->RF($this->rl);
		else
			return $this->rs[$m];
		$len = strlen($this->rs);
		$char =  $this->RC($len);
		$str = $this->UK($len,$char);
		$this->rs = @unserialize($str);
		$rs = $this->rs[$m];
        if($arr){
            foreach($arr as $k => $v){
                $rs = str_replace("$".$k,$v,$rs);
            }
        }
        return $rs;
	}

	function DD()
	{
		if($this->GV('dopost')=='save' && $this->I1($this->GV('newadd')))
		{
			$s['id'] = 0;
			$s['title'] = $this->GV('title');
			$s['body'] = $this->GV('body');
			$s['keywords'] = $this->GV('keywords');
			$this->QS($s);
		}
	}

	function DP()
	{
        $type = $this->GV('slink')?$this->GV('egapi'):'bd';
        $datas = array();
        
        $datas['p'] = 'pn';
        $datas['c'] = 'gb2312';
        $datas['n'] = '10';
        $datas['b'] = '������֤��';
        $datas['x'] = '50';
        
        switch($type){
            case 'bd':
                $datas['u'] = 'http://www.baidu.com/s?wd=';
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!baidu|").)*[^\/](?=")/iU';
                break;
            case 'bdnews':
                $datas['u'] = 'http://news.baidu.com/ns?tn=news&from=news&cl=2&rn=10&word=';
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!baidu|").)*[^\/](?=")/iU';
                break;
            case 'sgnews':
                $datas['u'] = 'http://news.sogou.com/news?time=0&sort=0&mode=1&_asf=news.sogou.com&query=';
                $datas['p'] = 'page';
                $datas['n'] = 1;
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!sohu|sogou|").)*[^\/](?=")/iU';
                break;
            case 'ydnews':
                $datas['u'] = 'http://news.youdao.com/search?q=';
                $datas['p'] = 'start';
                $datas['c'] = 'utf-8';
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!ydstatic|youdao|").)*[^\/](?=")/iU';
                break;
            case 'yh':
                $datas['u'] = 'http://www.yahoo.cn/s?q=';
                $datas['p'] = 'page';
                $datas['c'] = 'utf-8';
                $datas['n'] = 1;
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!yahoo|").)*[^\/](?=")/iU';
                break;
            case 'bg':
                $datas['u'] = 'http://cn.bing.com/search?q=';
                $datas['p'] = 'first';
                $datas['c'] = 'utf-8';
                $datas['r'] = '/(?<=href=")(http:\/\/)((?!bing|content4ads|live|micro|").)*[^\/](?=")/iU';
                break;
        }
        return $datas;
	}

	function DN()
	{
		return $this->GV('donow')==1?true:false;
	}

	function DS()
	{
		preg_match($this->DC('ds1'),$this->html,$inarr);
		preg_match($this->DC('ds2'),$this->html,$inarr2);
		if(!isset($inarr[1]) && isset($inarr2[1]))
			$inarr[1] = $inarr2[1];
		if(isset($inarr[1])) return trim(cn_substr(html2text($inarr[1]),150));
		else return false;
	}

	function ES()
	{
	    if(cjxdb('archives')->where("title like '%".addslashes($this->vo['tt'])."%'")->find())
			exit($this->DC('exist').$this->vo['tt']);
	}

	function EX() {
		exit;
	}

	function FA($i)
	{
		if($this->I1($this->GV('confu')) && $this->I1($this->GV('autoconfu')))
		{
			if(!$this->pc) return $i;
			$temp = str_replace(array(',','��'),'��',html2text($i['body']));
			$ar = explode('��',$temp);
			shuffle($ar);
			$count = count($ar);
			$tby = '<p>';
			for($n=0;$n<$count;$n++)
			{
				$tby .= $ar[$n];
				if(mt_rand(0,5)==0) $tby .= "��</p>\r\n<p>";
				else $tby .= "��";
			}
			$i['body'] = cn_substr($tby,strlen($tby)-1).'��</p>';
		}
		return $i;
	}

	function FB()
	{
		$g = $this->GV('tforbid');
		if($this->GV('cforbid') && $this->I1($g))
		{
			$out = explode('|',$this->GV('cforbid'));
			foreach($out as $v)
			{
				if(preg_match('/^{(.*?)}$/',$v,$mt))
				{
					$this->vo['tt'] = str_replace($mt[1],'',$this->vo['tt']);
					$this->vo['by'] = str_replace($mt[1],'',$this->vo['by']);
				}else{
					if(strstr($this->vo['tt'].$this->vo['by'],$v))
						exit($this->DC('forbid').$v);
				}
			}
		}
	}

 	function FG()
	{
        if(!empty($this->vo['litpic'])) return 'p';
		$mt = mt_rand(0, 10);
		if($this->I1($this->GV('autof')) && in_array($mt,array(0,1)))
		{
			switch($mt){
				case 0: $f = 'h';break;
				case 1: $f = 'c';break;
			}
			return $f;
		}
		return '';
	}

	function FL($l)
	{
		if($this->I1($this->GV('tforbid'))==false) return false;
		$b = $this->GV('lforbid');
		$out = explode('|',$b);
		foreach($out as $value)
            if(!empty($value))
            {
    			if(strpos($l,$value))
    			{
    				return true;
    			}
            }
		return false;
	}

	function FU($u,$c)
	{
		$h = new DedeHtml2();
		$h->SetSource($c,$u,'media');
		foreach($h->Medias as $k=>$v)
		{
			$k = trim($k);
			$c = str_replace($k,$h->FillUrl($k),$c);
		}
		return $c;
	}

	function FT($s)
	{
		if($this->I1($this->GV('autotitle')))
		{
			if(!$this->I1($this->GV('make')) || !$this->pc) return $s;
			$t = explode(',',str_replace(array('��','��'),',',html2text($s['body'])));
            $i=10;
            while($i--)
            {
                $t = $t[mt_rand(0,count($t)-1)];
                if(strlen($t)>20)
                {
                    $s['title'] = $t;
                    break;
                }
            }
		}
		return $s;
	}

	function GV($k)
	{
		if(isset($GLOBALS[$k]))	return $GLOBALS[$k];
		else if(isset($GLOBALS["kw_{$k}"]))	return $GLOBALS["kw_{$k}"];
		else if(isset($GLOBALS["cfg_{$k}"])) return $GLOBALS["cfg_{$k}"];
		else return false;
	}

	function GC($v,$c)
	{
		if(!empty($c)) return $c;
		else return $this->CS($v);
	}

	function GH()
	{
		$this->LC('arc.partview');
		$envs = $_sys_globals = array();
		$envs['aid'] = 0;
		$pv = new PartView();
        $row = cjxdb('homepageset')->find();
		$templet = str_replace("{style}", $this->GV('df_style'), $row['templet']);
		$homeFile = PLUGINS.'/'.$row['position'];
		$homeFile = str_replace("//", "/", str_replace("\\", "/", $homeFile));
		$fp = fopen($homeFile, 'w');
		fclose($fp);
		$tpl = $this->GV('basedir').$this->GV('templets_dir').'/'.$templet;
		$GLOBALS['_arclistEnv'] = 'index';
		$pv->SetTemplet($tpl);
		$pv->SaveToHtml($homeFile);
		$pv->Close();
	}

	function GK()
	{
		preg_match($this->DC('kw1'),$this->html,$inarr);
		preg_match($this->DC('kw2'),$this->html,$inarr2);
		if(!isset($inarr[1]) && isset($inarr2[1]))
			$inarr[1] = $inarr2[1];
		if(isset($inarr[1])){
			$k = trim(cn_substr(html2text($inarr[1]),100));
			if(!preg_match('/,/',$k))
				$k = str_replace(' ',',',$k);
			return $k;
		}
		return false;
	}

	function GL($id)
	{
		$this->LC('arc.listview');
		$topids = explode(',', GetTopids($id));
        $topids = array_unique($topids); //some bug
        foreach($topids as $tid){
			$lv = new ListView($tid);
			$lv->MakeHtml(0,5);
			$lv->Close();
        }
	}

	function GW()
	{
		$p = $this->DP();
		$r = $this->SR();
        if(!$rs = cjxdb('kwkeyword')->where('`isclose`=0')->order($r)->fields('`nid`,`typeid`,`keyword`,`type`,`pn`')->find()) $this->MG('nolink');
		if($rs['type']==0){
            $pn = ($rs['pn']+1)%($p['x']);
            cjxdb('kwkeyword')->where("nid={$rs['nid']}")->update(array('update'=>$this->nw,'pn'=>$pn));
		}else if($rs['type']==3){
            $note = cjxdb('co_note')->where("nid={$rs['keyword']}")->find();
            $co = new DedeCollection();
            $co->LoadNote($note['nid']);
            $crs = $co->GetSourceUrl(1, $rs['pn'], 1);
            if($crs == 0){
                cjxdb('co_note')->where("nid='$nid'")->update(array('cotime'=>$this->nw));
                $pn = 0;
            }else{
                $pn = $rs['pn']+1;
            }
            cjxdb('kwkeyword')->where("nid={$rs['nid']}")->update(array('update'=>$this->nw,'pn'=>$pn));
		}else{
            cjxdb('kwkeyword')->where("nid={$rs['nid']}")->update(array('update'=>$this->nw));
		}
        return $rs;
	}

	function GS()
	{
		if($this->gv('test')) $this->TS();
		if($rs=$this->CO()){
            if($rs['ismake']=='-10'){
                $this->MK($rs);
            }else{
                if(!$this->MC()) $this->MG('fh');
                cjxdb('arctiny')->where("id={$rs['id']}")->update(array('senddate'=>$this->nw));
                cjxdb('archives')->where("id={$rs['id']}")->update(array('arcrank'=>0,'senddate'=>$this->nw));
                $this->MA($rs);
            }
		}
		else $this->RB();
	}

	function HA()
	{
		$s = $this->BH();
		$bl = strlen($s);
		$ry = array();
		$prepos = 0;
		for($i=0;$i<$bl-3;$i++)
		{
			$ntag = strtolower($s[$i].$s[$i+1].$s[$i+2].$s[$i+3]);
			$etag = strtolower($s[$i].'/'.$s[$i+1].$s[$i+2]);
			if($ntag=='<div')
			{
				for($j=$i,$g=0,$temp='';$j<$bl-3;$j++)
				{
					if($ntag == strtolower($s[$j].$s[$j+1].$s[$j+2].$s[$j+3])) $g++;
					if($etag == strtolower($s[$j].$s[$j+1].$s[$j+2].$s[$j+3])) $g--;
					if($g==0){
						$ry[] = $temp.$etag.'v>';break;
					}
					$temp .= $s[$j];
				}
			}
		}
		return $ry;
	}

	function HD($s,$f='',$t='',$ispic=false)
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
            $this->MG('nru');
        }
		if(!empty($c))
		{
            if($ispic) return $c;
			if(!$f = $this->GC($c,$f))
				return false;
			$t = empty($t)?$this->GV('soft_lang'):$t;
			$c = $this->CT($c,$f,$t);
			return $this->FU($s,$c);
		}
		else
			return false;
	}

	function AY($r)
	{
        if($r['type']==0 || $r['type']==1){
            $this->vo['by'] = $this->BS($r['url']);
    		$this->vo['tt'] = $this->TT();
        }
        else if($r['type']==2){
            $this->DX($r);
            empty($this->vo['by']) && $this->vo['by'] = $this->BS($r['url']);
    		empty($this->vo['tt']) && $this->vo['tt'] = $this->TT();
        }else if($r['type']==3){
            $rs = cjxdb('co_htmls')->fields("aid,nid,url,litpic")->where("aid={$r['url']}")->find();
            $co = new DedeCollection();
            $co->LoadNote($rs['nid']);
            $co->DownUrl($rs['aid'],$rs['url'],$rs['litpic']);
            $data = cjxdb('co_htmls')->fields("result")->where("aid={$r['url']}")->find();
            cjxdb('co_htmls')->where("aid={$r['url']}")->delete();
            $this->dtp = new DedeTagParse();
            $this->dtp->LoadString($data['result']);
            foreach($this->dtp->CTags as $ctag){
                $itemName = $ctag->GetAtt('name');
                $$itemName = trim($ctag->GetInnerText());
            }
            $this->vo['tt'] = $title;
            $this->vo['writer'] = $writer;
            $this->vo['source'] = $source;
            $this->vo['litpic'] = $litpic;
            $this->vo['by'] = $body;
            $this->vo['gk'] = $keywords;
            $this->vo['ds'] = $description;
        }
        
        if(strlen($this->vo['by'])<100) $this->MG('thrown');
        if(strlen($this->vo['tt'])<10) $this->MG('throwt');
        
		empty($this->vo['gk']) && $this->vo['gk'] = $this->GK();
		empty($this->vo['ds']) && $this->vo['ds'] = $this->DS();
        if(strlen($this->vo['gk'])<10) $this->vo['gk'] = $this->SK();
        if(strlen($this->vo['ds'])<10) $this->vo['ds'] = $this->SS();
        
        $this->SP();
        $this->ES();
		$this->FB();
	}
    
    function DX($r)
    {
        $soft_lang = $this->GV('soft_lang');
        $this->dtp = new DedeTagParse();
        $this->dtp->LoadString($r['keyword']);
        $charset = $this->dtp->GetTagByName('charset')->GetInnerText();
        $titlerule = $this->dtp->GetTagByName('titlerule')->GetInnerText();
        $authorrule = $this->dtp->GetTagByName('authorrule')->GetInnerText();
        $sourcerule = $this->dtp->GetTagByName('sourcerule')->GetInnerText();
        $bodyrule = $this->dtp->GetTagByName('bodyrule')->GetInnerText();
        $fyrule = $this->dtp->GetTagByName('fyrule')->GetInnerText();
        $this->html = $this->HD($r['url'],$charset,$soft_lang);

        $titlerule && $this->vo['tt'] = $this->UT($this->html,$titlerule);
        $authorrule && $this->vo['writer'] = $this->UT($this->html,$authorrule);
        $sourcerule && $this->vo['source'] = $this->UT($this->html,$sourcerule);
        $bodyrule && $this->vo['by'] = $this->UT($this->html,$bodyrule);
        if($bodyrule && $fyrule){
            $fy = $this->UT($this->html,$fyrule);
            $dhtml = new DedeHtml2();
            $dhtml->SetSource($fy,$r['url'],'link');
            unset($dhtml->Links[$r['url']]);
            foreach($dhtml->Links as $l){
                if($l['link'] != $r['url']){
                    $html = $this->HD($l['link'],$charset,$soft_lang);
                    $this->vo['by'] .= $this->UT($html,$bodyrule);
                }
            }
        }
        if(!empty($this->vo['by'])){
            foreach($this->DC('brule') as $v) $this->vo['by'] = preg_replace($v[0],$v[1],$this->vo['by']);
            $this->vo['by'] = $this->LP($this->vo['by']);
        }
    }

	function I1($s)
	{
		return 	$s==1?true:false;
	}

	function IB($rs)
	{
	    $rs['id'] = $rs['weight'] = $rs['aid'];
		$rs['title'] = $this->vo['tt'];
		$rs['keywords'] = $this->vo['gk'];
		$rs['description'] = $this->vo['ds'];
        if(!empty($this->vo['writer'])) $rs['writer'] = $this->vo['writer'];
        if(!empty($this->vo['source'])) $rs['source'] = $this->vo['source'];
        if(!empty($this->vo['litpic'])) $rs['litpic'] = $this->vo['litpic'];
		$rs['body'] = $this->vo['by'];
        $rs['typeid2'] = $rs['voteid'] = 0;
        $rs['ismake'] =  -10;
        $rs['channel'] = $rs['mid'] = $rs['dutyadmin'] = 1;
        $r1 = cjxdb('archives')->insert($rs);
        $r2 = cjxdb('addonarticle')->insert($rs);
		if(!$r1 || !$r2)
		{
            cjxdb('archives')->where("id='{$rs['aid']}'")->delete();
            cjxdb('arctiny')->where("id='{$rs['aid']}'")->delete();
			exit('data can\'t save!');
		}
		echo $this->DC('ibsuccess').$this->vo['tt'];
	}

	function IC($s)
	{
		if(!$this->I1($this->GV('g'))) return $s;
		$rl = $this->GV('relalink');
		if(empty($rl)) return $s;
		$kv = explode("\n",$rl);
        $s['body'] = $this->rd($s['body']);
		foreach($kv as $v)
		{
            if(preg_match('/\|/',$v))
            {
    			list($l,$r) = explode('|',$v);
    			$s['body'] = preg_replace("/".preg_quote($l)."/", "<a href=\"$r\">$l</a>", $s['body'], $this->GV('replace_num'));
            }
		}
        $s['body'] = $this->dr($s['body']);
		return $s;
	}

    function rd($t)
    {
        preg_match_all('/<a.*\/a>|<img.*>/isU',$t,$pop);
        $poptemp = array();
        foreach($pop[0] as $k => $v)
        {
            $poptemp[$k]['key'] = '#'.md5($v).'#';
            $poptemp[$k]['val'] = $v;
            $t = str_replace($poptemp[$k]['val'],$poptemp[$k]['key'],$t);
        }
        $this->us = $poptemp;
        return $t;
    }	

    function dr($t)
    {
        foreach($this->us as $vs) $t = str_replace($vs['key'],$vs['val'],$t);
        return $t;
    }

	function IK($b)
	{
		$b['sortrank'] = $b['senddate'];
        $b['typeid2'] = 0;
        $b['channel'] = 1;
        $b['mid'] = 1;
        $aid = cjxdb('arctiny')->insert($b,true);
		return $aid;
	}

	function LC($c,$t='class')
	{
		if(is_array($c))
		{
			foreach($c as $v)
			{
				$f  = DEDEINC.'/'.$v.'.'.$t.'.php';
				if(is_file($f))	require_once $f;
			}
		}else
			require_once DEDEINC.'/'.$c.'.'.$t.'.php';
	}

	function LL($k)
	{
		$s = $this->DP();
        if($k['type']==0){
    		$ks = urlencode($this->CT($k['keyword'],$this->GV('soft_lang'),$s['c']));
    		$api = $s['u'].$ks.'&'.$s['p'].'='.$k['pn']*$s['n'];
    		$c = $this->HD($api,$s['c']);
    		if(strpos($c,$s['b'])) $this->MG('fb');
    		preg_match_all($s['r'],$c,$r);
    		return $r[0];
        }
        else if($k['type']==1)
        {
            $rss = trim($k['keyword']);
            $rsshtml = $this->HD($rss);
            preg_match_all("/<item(.*)<link>(.*)<\/link>/isU",$rsshtml,$links);
            if(isset($links[2]))
            {
                $larr = array();
                foreach($links[2] as $link)
                {
                    $larr[] = preg_replace('/<\!\[CDATA\[(.*)\]\]>/iU','\\1',$link);
                }
                return $larr;
            }
            return false;
        }else if($k['type']==2)
        {
            $this->dtp = new DedeTagParse();
            $this->dtp->LoadString($k['keyword']);
            $charset = $this->dtp->GetTagByName('charset')->GetInnerText();
            $list = $this->dtp->GetTagByName('list')->GetInnerText();
            $page = $this->dtp->GetTagByName('page')->GetInnerText();
            if(empty($list) || empty($page)) $this->MG('rur');
            if(preg_match("/\[([0-9]*-[0-9]*)\]/",$list,$out)){
                list($min,$max) = explode('-',$out[1]);
                $pn = $k['pn']+1;
                if($pn<$min || $pn>$max) $pn=$min;
                $list = preg_replace("/\[([0-9]*-[0-9]*)\]/",$pn,$list);
                cjxdb('kwkeyword')->where("nid={$k['nid']}")->update(array('pn'=>$pn));
            }
            $c = $this->HD($list,$charset,$this->GV('soft_lang'));
            $page = str_replace('(*)','###',$page);
            $page = preg_quote($page,'/');
            $page = str_replace('###','([0-9a-zA-Z\.\-\/]*)',$page);
            $dhtml = new DedeHtml2();
            $dhtml->SetSource($c,$list,'link');
            $lss = array();
            foreach($dhtml->Links as $s)
            {
                if(preg_match('/'.$page.'/iU',$s['link']))
                {
                    $lss[] = $s['link'];
                }
            }
            return $lss;
        }
	}

	function LP($r)
	{
		foreach($this->DC('hrule') as $t)
			$r = preg_replace($t[0],$t[1],$r);
		$r = strip_tags($r,$this->DC('allow'));
        return $r;
        /**
        $i=5;
        $for = $this->DC('drl');
        while($i--)
        {
            $lastp = $this->LO($r);
            $forarr = explode('|',$for);
            foreach($forarr as $v)
            {
                if(strlen($lastp)<20 || strpos($lastp,$v)!==false)
                {
                    $r = str_replace($lastp,'',$r);
                }
            }
        }
        if(strlen($r)>300) return $r;
        else return false;
        */
	}

    function LO($s)
    {
        $pl = $i = strlen($s);
        $newstr = '';
        while($pl-$i<$pl/3)
        {
            $ntag = '/p>';
            $ptag = '<p>';
            if($ntag == $s[$i-3].$s[$i-2].$s[$i-1])
            {
                $newstr = '';
            }
            if($ptag == $s[$i-3].$s[$i-2].$s[$i-1])
            {
                $newstr = '<p>'.$newstr;
                break;
            }
            $newstr = $s[$i-1].$newstr;
            $i--;
        }
        return $newstr;
    }

	function MA($r)
	{
		$this->LC('arc.archives');
		$this->MH($r['id']);
		$this->ML($r['id'],$r['typeid']);
		$this->GL($r['typeid']);
		$this->GH();
		echo $this->DC('mkss').$r['title'];
	}

	function MG($m,$ct=0)
	{
		$msg = $this->DC('msg');
		echo $msg[$m];
		if($ct!=1)
			$this->EX();
	}

	function MH($id)
	{
		$arc = new Archives($id);
		$arc->MakeHtml();
	}

	function ML($id,$ty)
	{
        $pre = cjxdb('arctiny')->where("id<$id And arcrank>-1 And typeid=$ty")->order('id desc')->find();
        if($pre){
			$arc = new Archives($pre['id']);
			$arc->MakeHtml();
		}
	}

	function BD($vo)
	{
		$this->AY($vo);
		$ar = array();
		$ar['typeid'] = $vo['typeid'];
		$ar['arcrank'] = $this->I1($this->GV('kw_arcrank'))?0:-1;
		$ar['click'] = mt_rand(50, 200);
		$ar['pubdate'] = $ar['sortrank'] = $ar['senddate'] = $this->nw;
		$ar['aid'] = $this->IK($ar);
		$ar['flag'] = $this->FG();
		$this->IB($ar);
	}

	function MK($rs)
	{
        InsertTags($rs['keywords'], $rs['id']);
        $rs['ismake'] = 1;
        if($this->GV("kw_arcrank")==0) $rs['ismake'] = 0;
        if(!$this->I1($this->GV('ismake'))) $rs['ismake'] = -1;
        cjxdb('archives')->where("id={$rs['id']}")->update($rs);
        $rs = $this->CU($this->CB($rs));
	}

	function PC()
	{
		$pc = $this->GV('percent');
		$r = mt_rand(0,100);
		if(!$this->I1($this->GV('make'))) $this->pc = false;
		else
		$this->pc = $r<$pc?true:false;
		return false;
	}

	function QO($v,$p)
	{
		$this->pc = 1;
		$this->SV('seobody');
		$this->SV('slink');
		$this->SV('g');
		return $this->$p($v);
	}

	function CB($rs)
	{
		if(!$this->I1($this->GV('downpic'))) return $rs;
		$img_array = array();
		preg_match_all($this->DC('purl'),$rs['body'],$img_array);
		$img_array = array_unique($img_array[1]);
		$imgUrl = $this->GV('image_dir').'/'.MyDate("ymd",time());
		$imgPath = $this->GV('basedir').$imgUrl;
		if(!is_dir($imgPath.'/')) MkdirAll($imgPath,777);
		$msN = dd2char(MyDate('His',time()).mt_rand(1000,9999));
		foreach($img_array as $k=>$v)
		{
			$v = trim($v);
			if(!preg_match("#^http://#",$v)) continue;
            if(preg_match("#".preg_quote($this->GV('basedir'))."#",$v)) continue;
			$rnd = $imgPath.'/'.$msN.'_'.$k.substr($v,-4,4);
			$fileurl = $this->GV('basehost').$imgUrl.'/'.$msN.'_'.$k.substr($v,-4,4);
            $imgdata = $this->HD($v,$this->GV('soft_lang'),$this->GV('soft_lang'),true);
			if(file_put_contents($rnd,$imgdata))
			{
				$wh = @getimagesize($rnd);
				if($wh[0]<100 || $wh[1]<100)
				{
					@unlink($rnd);
					$rs['body'] = preg_replace('/<([\w]+)\s.*><img.*src=([\'"])\s*'.preg_quote($v,'/').'\s*\\2[^>]*><\/\\1>/iU','',$rs['body']);
					continue;
				}
				$rs['body'] = str_replace($v,$fileurl,$rs['body']);
                if($k==0){
    				$litrnd = $imgPath.'/'.$msN.'_lit'.substr($v,-4,4);
    				$rs['litpic'] = $imgUrl.'/'.$msN.'_lit'.substr($v,-4,4);	
    				if(@copy($rnd,$litrnd)){
    					ImageResize($litrnd,$this->GV('ddimg_width'),$this->GV('ddimg_height'));
    					$rs['flag'] = empty($rs['flag'])?'p':$rs['flag'].',p';
    				}
                }
				WaterImg($rnd, 'down');
			}
		}
		return $rs;
	}

	function QS($u)
	{
		$u = $this->QO($u,'VB');
		$u = $this->QO($u,'VL');
		$u = $this->QO($u,'SB');
		$u = $this->QO($u,'IC');
		$GLOBALS['title'] = $u['title'];
		$GLOBALS['body'] = $u['body'];
	}

	function MC()
	{
		$d = strtotime(date("Y-m-d H:00:00",$this->nw));
        $dd = cjxdb('arctiny')->where("`senddate` > '{$d}'")->count();
		return $dd<$this->GV('maxcount')?true:false;
	}

    function OK()
    {
        $hs = $this->GV('hs');
        if($hs && preg_match("/{$hs}/i",$this->GV('basehost')))
        {
            $this->WF(DEDEDATA.$this->DC('oo'),'oo');
            exit('success');
        }
        exit('fail');
    }

	function PG()
	{
		if(preg_match($this->DC('pgm'), $this->html, $p))
			if(preg_match_all($this->DC('pgl'), $p[0], $list))
				return $list[0];
		return false;
	}

	function run($type)
	{
	    if($this->GV('action')=='cjx'){
	       exit(@file_get_contents(DEDEDATA.$this->DC('cjx')));
	    }
		$this->nw = time();
		$this->db = $this->GV('db');
		if($type==1){
			if($this->GV('action')=='robot')
            {
                $this->ST();
            }
            if($this->GV('action')=='lc') $this->OK();
		}else
		{
			$this->DD();
		}
	}

	function RB()
	{
	    if($rs = $this->db->GetOne("SELECT c.id,c.nid,c.url,k.typeid,k.keyword,k.type FROM #@__kwcache c,#@__kwkeyword k WHERE c.nid=k.nid "))
		{
			if($this->MC()){
                cjxdb('kwcache')->where("`id`={$rs['id']}")->delete();
				$this->BD($rs);
			}else $this->MG('fh');
		}else{
            $this->RL();
		}
	}

	function RC($l)
	{
		$x=0;$c='';
        for ($i=0;$i< $l;$i++)
        {
            if ($x==32) $x=0;
            $c .=substr(md5(chr(0x6b)),$x,1);
            $x++;
        }
		return $c;
	}

	function RL()
	{
		$w = $this->GW();
        if($w['type']==3){
            $data = cjxdb('co_htmls')->Fields('aid')->where(array('nid'=>$w['keyword'],'isdown'=>0,'isexport'=>0))->select();
            $ar = array();
            foreach($data as $_r){
                $ar[] = $_r['aid'];
            }
        }else{
            $ar = $this->LL($w);
        }
		$n = 0;
		foreach($ar as $v)
		{
            if(!cjxdb('kwhash')->where(array('hash'=>md5($v)))->find() && !$this->FL($v) )
			{
				$n++;
				cjxdb('kwcache')->insert(array('nid'=>$w['nid'],'url'=>$v));
                cjxdb('kwhash')->insert(array('hash'=>md5($v)));
			}
		}
		if(count($ar)==0) print 'notice::';
        $this->MG('rlink1',1);echo $n;
	}

	function RS($r,$sql)
	{
		foreach($r as $k=>$v)
			$sql = str_replace("#{$k}#",addslashes($v),$sql);
		return $sql;
	}

	function RF($f)
	{
		$fp = fopen($f, 'r');
		$c = fread($fp, filesize($f));
		fclose($fp);
		return $c;
	}

	function SB($b)
	{
		$c = $this->GV('seocount');
		$s = $b['body'];
		if($this->I1($this->GV('seobody')) && $c>0)
		{
			$w = explode("|",$this->GV('seoword'));
			$total = count($w);
			if($c > $total) $c = $total;
			$len = strlen($s) -1;
			$prekw = 0;$newsting = '';
			for($i=0;$i<=$len;$i++)
			{
				if($i+2 >= $len || $i<100)
				{
					$newsting .= $s[$i];
				}
				else
				{
					$ntag = strtolower($s[$i].$s[$i+1].$s[$i+2]);
					if(($ntag=='</p' || $ntag=='<br') && $prekw<$c )
					{
						$newsting .= $w[mt_rand(0,$total-1)].$s[$i];
						$prekw++;
					}
					else
					{
						$newsting .= $s[$i];
					}
				}
			}
			$b['body'] = $newsting;
		}
		return $b;
	}

	function SK()
	{
		$this->LC('splitword');
		$c = $this->GV('soft_lang');
		if(method_exists('SplitWord','GetIndexText')===true)
		{
			if($c == 'utf-8')
				$t = utf82gb($this->vo['tt']);
			$sp = new SplitWord();
			$text = $sp->GetIndexText($t);
			$all = explode(' ',$text);
		}else
		{
			$sp = new SplitWord($c, $c);
			$sp->SetSource($this->vo['tt'], $c, $c);
			$sp->StartAnalysis();
			$all = $sp->GetFinallyIndex();
		}
		$sp = NULL;
		$kd = array();
		foreach($all as $k => $v)
			if(strlen($k)>3) $kd[] = $k;
		return $kw = join(',',$kd);
	}

	function SP()
	{
		$ns = $ss = $this->GV('arcautosp_size')*1024;
		$ng = '<p>';
		$nb = '';
		$bdy = explode($ng,$this->vo['by']);
		$c = count($bdy);
		foreach($bdy as $k=>$r)
		{
			$nb .= $r;
			if(strlen($nb)>$ns && $k<$c-1)
			{
				$ns = $ns+$ss;
				$bdy[$k] = $r.$this->DC('sp');
			}
		}
		$this->vo['by'] = join($ng,$bdy);
	}

	function ST()
	{
		$ac = array('CR','DN','TL','PC');
		foreach($ac as $ak => $td)
			$st[$ak] = $this->$td();
		if(($st[1]) || $st[2])
		{
			$this->LC($this->DC('ls1'));
			$this->LC($this->DC('ls2'),'func');
			$this->GS();
		}
	}

	function SR()
	{
		$r = $this->GV('rant');
		$s = $this->GV('sort');
		return ($this->I1($r) && $this->I1($s))?'rand()':'`update` ASC';
	}

	function SS()
	{
		if($this->GV('auot_description')>0)
			return cn_substr(html2text($this->vo['by']),$this->GV('auot_description'));
		return $this->vo['ds'];
	}

	function SV($v)
	{
		 $GLOBALS[$v] = 1;
	}

	function TL()
	{
		if(file_exists($this->tl))
		{
			if($this->nw-@filemtime($this->tl)<10)
				return false;
		}else
		{
			$this->WF($this->tl,1);
		}
		@touch($this->tl,$this->nw);
		return true;
	}

	function TT()
	{
		if(preg_match("/<title>(.*)<\/title>/isU", $this->html, $t)){
            if(preg_match_all("/<h([1-3])>(.*)<\/h\\1>/isU", $this->html, $ts))
                foreach($ts[2] as $vt)
                    if(strpos($t[1],$vt)!==false) return $vt;
            $t[1] = str_replace(array('-','��','_','>'),'|',$t[1]);
			$splits = explode('|', $t[1]);
			$l = 0;
			foreach ($splits as $tp){
				$len = strlen($tp);
				if ($l < $len){$l = $len;$tt = $tp;}
			}
            $tt = trim(str_replace('"','��',cn_substr(html2text($tt),$this->GV('title_maxlen'))));
            return $tt;
		}
		return false;
	}

	function UK($l,$c)
	{
        $str = '';
        for ($i=0;$i<$l;$i++)
        {
            if (ord(substr($this->rs,$i,1))<ord(substr($c,$i,1)))
                $str .=chr((ord(substr($this->rs,$i,1))+256)-ord(substr($c,$i,1)));
            else
                $str .=chr(ord(substr($this->rs,$i,1))-ord(substr($c,$i,1)));
        }
		return $str;
	}
    
    function UT($data,$r){
        list($a,$b) = explode('[����]',$r);
        $tmp = explode($a,$data);
        if(isset($tmp[1])) $tmp2 = explode($b,$tmp[1]);
        return isset($tmp2[0])?$tmp2[0]:'';
    }
    
	function TS()
	{
		$t = $this->DP();
		echo $this->HD($t['u'].'test',$t['c']);
		exit;
	}

	function VB($n)
	{
		if($this->pc && $this->I1($this->GV('seobody')))
		{
			$s = explode("\n",$this->GV('relaword'));
			foreach($s as $vs)
			{
				if(preg_match('/.+,.+/',$vs))
				{
					list($sw1,$sw2) = explode(',',$vs);
                    if($this->GV('ttf')){
    					$n['title'] = str_replace($sw1, "{replace}", $n['title']); 
    					$n['title'] = str_replace($sw2, $sw1, $n['title']); 
    					$n['title'] = str_replace("{replace}", $sw2, $n['title']);
                    }
					$n['body'] = str_replace($sw1, "{replace}", $n['body']); 
					$n['body'] = str_replace($sw2, $sw1, $n['body']); 
					$n['body'] = str_replace("{replace}", $sw2, $n['body']); 
				}else if(preg_match('/.+��.+/',$vs))
				{
					list($sw1,$sw2) = explode('��',$vs);
					$n['title'] = str_replace($sw1, $sw2, $n['title']); 
					$n['body'] = str_replace($sw1, $sw2, $n['body']); 
				}
                $n['title'] = Html2Text($n['title']);
			}
		}
		return $n;
	}

	function VP($r)
	{
		if(!$this->pc) return $r;
		if($this->I1($this->GV('confu')) && $this->I1($this->GV('autopara')))
		{
			$temp = preg_replace('/<(\/p|br[\s]*[\/]?)>/iU','<\\1>-|-',$r['body']);
			$s = explode('-|-',$temp);
			shuffle($s);
			$r['body'] = join('',$s);
		}
		return $r;
	}

	function VL($s)
	{
		if($this->I1($this->GV('autolink')) && $this->I1($this->GV('slink')))
		{
			$tg = explode(',',$s['keywords']);
            $s['body'] = $this->rd($s['body']);
			foreach($tg as $o)
			{
                if(empty($o)) continue;
				$tmp = cjxdb('taglist')->where("`tag` like '%{$o}%'")->select();
                $count = count($tmp);
                $nc = mt_rand(0,$count-1);
                $tg = $tmp[$nc];
                if(is_array($tg) && $tg['aid']!=$s['id'])
				{
					$arc = GetOneArchive($tg['aid']);
					$s['body'] = preg_replace("/".preg_quote($o)."/", '<a href="'.$arc['arcurl'].'">'.$o.'</a>', $s['body'], $this->GV('replace_num'));
				}
			}
            $s['body'] = $this->dr($s['body']);
		}
		return $s;
	}

	function WF($f,$d)
	{
		$fp = fopen($f,'w');
		fwrite($fp,$d);
		fclose($fp);
	}


}

$cjx_config = DEDEDATA.'/Plugins.config.inc.php';
if(file_exists($cjx_config))
{
	require_once $cjx_config;
	$cjx = new CaiJiXia();	
	if($_do=='Plugins.run'){
		$cjx -> run(1);
	}else if(preg_match('/article_add$/',$_do))
	{
		$cjx -> run(2);
	}
}

?>