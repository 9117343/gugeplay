<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>会员空间留言管理</title>
<link href="img/base.css" rel="stylesheet" type="text/css">
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script language="javascript">
//获得选中文件的文件名
function getCheckboxItem(){
	 var allSel="";
	 if(document.form1.logs.value) return document.form1.logs.value;
	 for(i=0;i<document.form1.logs.length;i++)
	 {
		 if(document.form1.logs[i].checked){
			 if(allSel=="")
				 allSel=document.form1.logs[i].value;
			 else
				 allSel=allSel+"`"+document.form1.logs[i].value;
		 }
	 }
	 return allSel;	
}

function ReSel(){
	for(i=0;i<document.form1.logs.length;i++){
		if(document.form1.logs[i].checked) document.form1.logs[i].checked = false;
		else document.form1.logs[i].checked = true;
	}
}

function DelSel(){
	 var nid = getCheckboxItem();
	 if(nid==""){
		  alert("请选择项目!\r\n");
		  return ;
	 }
	 location.href = "member_guestbook.php?dopost=del&ids="+nid;
}
function delFeedbackIP()
{
	var nid=getCheckboxItem();
	if(nid=="") alert("你没选中任何内容！");
	else if(window.confirm('你确定要删除这些留言吗?')) location.href="member_guestbook.php?dopost=delall&ids="+nid;
}

function delUname()
{
	var nid=getCheckboxItem();
	if(nid=="") alert("你没选中任何内容！");
	else if(window.confirm('你确定要删除这些留言吗?')) location.href="member_guestbook.php?dopost=deluname&ids="+nid;
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D1DDAA" align="center">
  <tr>
    <td height="28" colspan="7" background='img/tbg.gif'><table width="96%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="20%" height="18"><strong>会员空间留言管理：</strong></td>
        <td width="80%" align="right">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr align="center" bgcolor="#FFFFFF">
    <td><a href="member_guestbook.php">全部记录</a></td>
    <td colspan="6"><table width="90%" border="0" cellspacing="0" cellpadding="0">
      <form name='formsearch'>
        <tr>
          <td> 搜索：
            <select name="ways" id="ways">
              <option value="uname" selected>留言者</option>
              <option value="userid">空间UID</option>
              <option value="msg">内容</option>
            </select>
            <input type="text" name="body" id="body">
            <input type="submit" name="Submit" value="搜索" />
            </td>
        </tr>
      </form>
    </table></td>

  </tr>
  <tr align="center" bgcolor="#FAFAF1">
    <td width="8%">选择</td>
    <td width="11%">ID</td>
    <td width="11%">空间UID</td>
    <td width="11%">留言者</td>
    <td>留言内容</td>
    <td width="11%">IP</td>
    <td width="15%">时间</td>
  </tr>
  <form name="form1">
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF">
      <td><input name='logs' type='checkbox' class='np' id="logs" value='<?php echo $fields['aid']; ?>' /></td>
      <td width="11%"><?php echo $fields['aid']; ?> </td>
      <td><a href="member_guestbook.php?mid=<?php echo $fields['mid']; ?>"><?php echo $fields['userid']; ?></a></td>
      <td><a href="member_guestbook.php?uname=<?php echo $fields['uname']; ?>"><?php echo $fields['uname']; ?></a></td>
      <td><?php echo $fields['msg']; ?></td>
      <td><?php echo $fields['ip']; ?></td>
      <td> <?php echo GetDateMk($fields['dtime']); ?> </td>
    </tr>
    <?php
}
?>
  </form>
  <tr>
    <td height="30" colspan="7" bgcolor="#FCFDF7">&nbsp;
      <input type="button" name="b5" value="反选"  style="width:40px" class="coolbg np" onClick="ReSel();" />
      &nbsp;
      <input type="button" name="b6" value="删除所选"  style="width:80px" class="coolbg np" onClick="DelSel();" />
      <input type='button' name='db' value=' 删除相同IP的所有留言 ' onClick="delFeedbackIP()" class="coolbg np" />
      <input type='button' name='db' value=' 删除相同留言者的所有留言 ' onClick="delUname()" class="coolbg np" />
    </td>
  </tr>
  <tr bgcolor="#E3F7D2">
    <td height="24" colspan="7" align="center" bgcolor="#FFFFFF"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>