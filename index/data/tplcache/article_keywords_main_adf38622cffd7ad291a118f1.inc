<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>关键字管理</title>
<link href="img/base.css" rel="stylesheet" type="text/css">
<link href="div.css" rel="stylesheet" type="text/css">
<style>
	.nnpp{
	border-bottom:1px solid #666666;
	border-top:1px solid #FFFFFF;
	border-left:1px solid #FFFFFF;
	border-right:1px solid #FFFFFF;
	filter:alpha(opacity=50);
 }
</style>
<script language='javascript'>
function selAll()
{
	var celements = document.getElementsByName('aids[]');
	for(i=0;i<celements.length;i++)
	{
		if(!celements[i].checked) celements[i].checked = true;
		else celements[i].checked = false;
	}
}
</script>
</head>
<body background='img/allbg.gif' leftmargin='8' topmargin='8'>
<div class="main">
  <table width="98%" border="0" cellpadding="1" align='center' cellspacing="1" bgcolor="#D1DDAA">
    <tr>
      <td height="26" colspan="6" background="img/tbg.gif"><table width="96%" border="0">
          <tr>
            <td width="25%"><strong>关键词维护</strong></td>
            <form name='form1' action="article_keywords_main.php">
            <td width="75%" align="right">
   	        搜索：<input type='text' name='keyword' size='20' />
   	        <input type='submit' name='sb' value='确定' class="coolbg np" />
   	        &nbsp;
            <input class="coolbg np" name="n1" type="button" id="n1" value="分析系统内的关键字" onClick="location='article_keywords_make.php';" style="width:130px" />
            &nbsp;
            <input class="coolbg np" name="n11" type="button" id="n11" value="管理搜索的关键字" onClick="location='search_keywords_main.php';" style="width:125px" />
            </td></form>
          </tr>
        </table></td>
    </tr>
    <form name='form2' action="article_keywords_main.php">
    	<input type='hidden' name='dopost' value='add' />
      <tr align="center" bgcolor="#F0FDDB">
        <td width="100%" height="24" colspan="6">
        	<table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="100" align="center">新增关键字：</td>
              <td width="140"><input name="keyword" type="text" id="keyword" style="width:130px" /></td>
              <td width="60">链接网址：</td>
              <td width="140"><input name="rpurl" type="text" id="rpurl" style="width:130px" /></td>
              <td width="40">频率：</td>
              <td width="50"><input name="rank" type="text" id="rank" style="width:30px" value="30" /></td>
              <td width="80"><input type="submit" name="Submit" value="保存" class="coolbg np" /></td>
            </tr>
          </table>
          </td>
      </tr>
    </form>
    <tr align="center" bgcolor="#F9FCEF" height="24">
      <td width="8%">选择</td>
      <td width="25%">关键字</td>
      <td width="35%">链接网址</td>
      <td width="10%">频率</td>
      <td width="22%">管理</td>
    </tr>
	 <form name='form3' action="article_keywords_main.php" method="post">
		<input type='hidden' name='dopost' value='saveall' />
   <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#f4fbf4';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td height="24">
      	<input name="aids[]" type="checkbox" value="<?php echo $fields['aid']; ?>" class="np" checked='1' />
      </td>
      <td>
      	<input type='hidden' value='<?php echo $fields['keyword']; ?>' name='keyword_<?php echo $fields['aid']; ?>' />
      	<?php echo $fields['keyword']; ?>
      </td>
      <td>
      	<input type='hidden' value='<?php echo $fields['rpurl']; ?>' name='rpurlold_<?php echo $fields['aid']; ?>' />
      	<input type='text' style='width:90%' class='nnpp' value='<?php echo $fields['rpurl']; ?>' name='rpurl_<?php echo $fields['aid']; ?>' />
      </td>
      <td>
      	<input type='text' size='5' class='nnpp' value='<?php echo $fields['rank']; ?>' name='rank_<?php echo $fields['aid']; ?>' />
      </td>
      <td>
      	<input type='hidden' name='staold_<?php echo $fields['aid']; ?>' value='<?php echo $fields['sta']; ?>' />
      	<input type='checkbox' name='isnouse_<?php echo $fields['aid']; ?>' class='np' value='1'<?php echo GetSta($fields['sta']); ?> />
      	禁用
      	&nbsp;
      	<input type='checkbox' name='isdel_<?php echo $fields['aid']; ?>' class='np' value='1' />
      	删除
      </td>
    </tr>
<?php
}
?>
     <tr bgcolor="#F0FBBD">
      <td height="28" colspan="6">
	    &nbsp;
	    <input type="button" name="dl1" class="coolbg np" value="反选" onClick="selAll()" />
	    &nbsp;
	    <input type="button" name="dl2" class="coolbg np" value="保存更改" onClick="this.form.submit();" />
	  </td>
    </tr>
	</form>
    <tr align="center" bgcolor="#FAFDF0">
      <td height="28" colspan="6">
      	<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '3';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

      </td>
    </tr>
  </table>
</div>
</body>
</html>