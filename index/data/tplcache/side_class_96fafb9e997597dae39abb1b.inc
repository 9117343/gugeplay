<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();

if($action=='article')
{
	  	$action = 'article';
	  	$channelid = 1;
}
else if($action=='album')
{
	  	$action = 'album';
	  	$channelid = 2;
}
else
{
	  	$action = 'archives';
	  	$channelid = empty($channelid) ? 0 : intval($channelid);
}
if($channelid >= 0)
{
	$channelAdd = '';
	if($channelid > 2) $channelAdd = '&channelid='.$channelid;
?>
<!-- //begin dirs -->
<dl class="border mT10">
      <dt class="caption"><strong>��־����</strong></dt>
      <dd class="body lh20">
        <ul class="list2 mB5">
    <?php
	  if (count($mtypearr)>0)
	  {
	  	foreach ($mtypearr as $mty)
	  	{ 
	  		if(!empty($channelid) && $mty['channelid'] != $channelid) continue;
				echo "<li><a href=\"index.php?uid={$_vars['userid_e']}&action={$action}&mtype={$mty['mtypeid']}{$channelAdd}\">{$mty['mtypename']}</a></li>\r\n";
	 		}
	 	}
		?>
		<li><a href="index.php?uid=<?php echo $GLOBALS['_vars']['userid_e']; ?>&action=<?php echo $action.$channelAdd; ?>">�����ĵ�&gt;&gt;</a></li>
        </ul>
      </dd>
    </dl>
<!-- //end dirs -->
<?php
}
?>