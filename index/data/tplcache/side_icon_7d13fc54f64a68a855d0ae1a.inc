<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!-- //begin icon -->
<dl class="border">
	<dt class="caption"><strong>��������</strong></dt>
	<dd class="body" id="userInfo"> <a class="pic" href="index.php?uid=<?php echo urlencode($GLOBALS['_vars']['userid']); ?>&action=infos" title="�ҵ�����">    <h4 style=" text-align:center"><?php echo $GLOBALS['_vars']['uname']; ?></h4><?php if($_vars['face']==''){ ?> <img src="space/person/common/images/noavatar.gif" alt="<?php echo $row['uname']; ?>��û����ͷ��" /> <?php
}
else{
?> <img src="<?php echo $GLOBALS['_vars']['face']; ?>" alt="<?php echo $GLOBALS['_vars']['uname']; ?>��ͷ��" /> <?php } ?></a>
		<div class="textCenter dashed pB10">
			 <h6 class="mT5 mB10"><?php echo $GLOBALS['_vars']['msg']; ?></h6>
				<ul class="w50 buttonBlue grayA">
            <li class="mB5"><a href="index.php?action=guestbook&uid=<?php echo $GLOBALS['_vars']['userid']; ?>"><span>��������</span></a></li>
            <li class="mB5"><a href="pm.php?dopost=send&uid=<?php echo $GLOBALS['_vars']['userid']; ?>"><span>������Ϣ</span></a></li>
            <li><a href="index.php?action=newfriend&uid=<?php echo $GLOBALS['_vars']['userid']; ?>"><span>��Ϊ����</span></a></li>
            <li><a href="index.php?action=blackfriend&uid=<?php echo $GLOBALS['_vars']['userid']; ?>"><span>�Ӻ�����</span></a></li>
				</ul>
				<div class="clear"></div>
			</div>
			<ul class="mT10 mL10 mB10 lh20">
          <li>��Ա�ȼ���<?php echo $GLOBALS['_vars']['membername']; ?></li>
          <li>��Ա���֣�<?php echo $GLOBALS['_vars']['scores']; ?>��</li>
          <li>�ռ���ʣ�<?php echo $GLOBALS['_vars']['homecount']; ?>��</li>
			</ul>
	</dd>
</dl>
<!-- //end icon -->