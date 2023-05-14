<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>投票管理</title>
<link href='img/base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D1DDAA">
  <tr>
   <td height="28" background="img/tbg.gif" colspan="6">
     <b>投票管理</b>&nbsp;[<a href="vote_add.php"><u>增加一组投票</u></a>]
	</td>
</tr>
  <tr align="center" bgcolor="#F9FCEF" height="24"> 
      <td width="8%">投票ID</td>
      <td width="27%">投票名称</td>
      <td width="15%">开始时间</td>
      <td width="15%">结束时间</td>
      <td width="10%">投票总数</td>
      <td width="25%">管理</td>
   </tr>
        <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
foreach( $blockValue as $key=>$fields )
{
?>
         <tr align="center" bgcolor="#FFFFFF" height="24" 
         	onMouseMove="javascript:this.bgColor='#f4fbf4';" onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
          <td><?php echo $fields['aid']; ?></td>
          <td>
          	<a href='<?php echo $GLOBALS['cfg_phpurl']; ?>/vote.php?aid=<?php echo $fields['aid']; ?>&dopost=view' target='_blank'>
          	<u><?php echo $fields['votename']; ?></u>
          	</a>
          </td>
          <td><?php echo GetDateMk($fields['starttime']); ?></td>
          <td><?php echo GetDateMk($fields['endtime']); ?></td>
          <td><?php echo $fields['totalcount']; ?></td>
          <td>
          	<a href='vote_getcode.php?aid=<?php echo $fields['aid']; ?>'>[获取代码]</a>
          	<a href='vote_edit.php?aid=<?php echo $fields['aid']; ?>&dopost=edit'>[更改]</a>
		        &nbsp;
		        <a href='vote_edit.php?aid=<?php echo $fields['aid']; ?>&dopost=delete'>[删除]</a>
		      </td>
        </tr>
		<?php
}
?>
     <tr align="center" bgcolor="#F9FCEF" height="24"> 
      <td colspan="6"><?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
</td>
     </tr>
   </table>
   </td>
</tr>
</table>
</body>
</html>