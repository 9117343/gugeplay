<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=gb2312'>
<title>插件管理</title>
<link href='img/base.css' rel='stylesheet' type='text/css'>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D1DDAA">
  <tr> 
    <td height="28" colspan="5" background="img/tbg.gif">
    	<table width='96%' cellpadding='0' cellspacing='0'>
    		<tr>
    		<td width='30%'><b>插件管理</b></td>
        <td align='right'>
    	  [<a href="module_main.php?moduletype=plus"><u>安装新插件</u></a>]
        </td>
      </tr>
     </table>
    </td>
  </tr>
  <tr align="center" bgcolor="#F9FCEF" height="24"> 
      <td width="10%">ID号</td>
      <td width="40%">插件名称</td>
      <td width="20%">插件作者</td>
      <td width="30%">管理</td>
   </tr>
   <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" height="24" onMouseMove="javascript:this.bgColor='#f4fbf4';" 
    	onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
        <td><?php echo $fields['aid']; ?></td>
        <td><?php echo $fields['plusname']; ?></td>
        <td><?php echo $fields['writer']; ?></td>
        <td><?php echo GetSta($fields['isshow'],$fields['aid'],$fields['plusname']); ?></td>
     </tr>
		<?php
}
?>
     <tr align="center" bgcolor="#F9FCEF" height="36"> 
      <td colspan="5">
      	<?php
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