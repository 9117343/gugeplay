<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
 ?>
<div class="wrapper mT10">
  <div class="west">
  <?php include $this->CompilerInclude("side_icon.htm");
  include $this->CompilerInclude("side_class.htm");
  include $this->CompilerInclude("side_visitor.htm");
  include $this->CompilerInclude("side_search.htm");
 ?>
  </div>
  <div class="east">
    <dl class="border">
      <dt class="caption"><strong>��־����</strong></dt>
      <dd class="body">
<div class="mp10 dashed">
		<div class="mB10">
			<h3 class="fLeft"><?php echo $GLOBALS['arcrow']['title']; ?></h3>
			<span class="mL5 aGray">(<?php echo MyDate('y-m-d h:i',$GLOBALS['arcrow']['pubdate']); ?>)</span>
		</div>
		<table class="blog-content">
		  <tr>
			<td>
			  <p><?php echo $GLOBALS['arcrow']['body']; ?></p>
			</td>
		  </tr>
		</table>
    <div class="clearfix"></div>
</div>

<!-- //���ۿ�ʼ -->
<div class="comment" style="padding-left:6px;">
<?php if (count($msgs)>0)  { ?>
<h5 id="cdisplay" style="display:;">һ���� <span id="sums"><?php echo count($msgs);?></span> ������</h5>
<?php
//ԭ�����ۣ�ȡ��ǰ50����
foreach ($msgs as $msg)
{
?>
<dl id="<?php echo $msg['id']; ?>">
	<dd class="comment-pic left">
		<img src="<?php echo $msg['mface']=='' ? 'images/dfboy.png' : $msg['mface']; ?>" width="40" />
	</dd>
	<dd>
	<?php
		if ($msg['username']=='����' || $msg['userid']=='') {
				echo $msg['username'];
		}
		else {
	?>
	<a href="index.php?uid=<?php echo urlencode($msg['userid']); ?>" class="big b"><?php echo $msg['username']; ?></a>
	<?php } ?>
	<span class="gray"><?php echo MyDate('m-d H:i',$msg['dtime']);?></span> Says:
	</dd>
	<dd class="comment-content" >
		<span id="s_<?php echo $msg['id']; ?>"></span>
		<div id="r_<?php echo $msg['id']; ?>">
			<div class="re-comment" style="display:none;">
				<b><?php echo $msg['username']; ?> �� <?php echo MyDate('m-d H:i',$msg['dtime']);?> �ظ���</b>
				<div id="r_content_<?php echo $msg['id']; ?>"></div>
			</div>
			<div>
				<img src="<?php echo $GLOBALS['cfg_templets_skin']; ?>/images/mood/<?php echo 'ico-mood-'.($msg['face']>0 ? $msg['face'] : 6).'.gif'; ?>" /><?php echo $msg['msg']; ?>
			</div>
		</div>
	</dd>
</dl>
<?php
} }
?>
	<div class="big"></div>
<form action="feedback.php" method="post" name="feedback">
	<div class="post-comment">
	<h5>��������</h5>
	<div>
		<?php echo $GLOBALS['_vars']['uname']; ?>��
		<input type="hidden" name="action" value="send" />
		<input type="hidden" name="comtype" value="comments">
		<input type="hidden" name="aid" value="<?php echo $aid; ?>" />
		<input type="hidden" name="isconfirm" value="yes" />
		<input type="hidden" name="cmtuser" value="<?php echo $GLOBALS['_vars']['uname']; ?>">
	</div>
	<div>
		<textarea class="ip" id="cmtcontent" name="msg" style="width:90%;height:60px" ></textarea>
	</div>
	<div class="c"></div>
	<div class="feedbackface""> 
		<strong style="FLOAT:left;">����:</strong>
			<ul>
				<li><input type="radio" name='face' value='6' checked="1" /><img src="templets/images/smiley/6.gif" /></li>
				<li><input type="radio" name='face' value='4'/><img src="templets/images/smiley/4.gif" /></li>
				<li><input type="radio" name='face' value='3'/><img src="templets/images/smiley/3.gif" /></li>
				<li><input type="radio" name='face' value='5'/><img src="templets/images/smiley/5.gif" /></li>
				<li><input type="radio" name='face' value='2'/><img src="templets/images/smiley/2.gif" /></li>
				<li><input type="radio" name='face' value='1'/><img src="templets/images/smiley/1.gif" /></li>
				<li><input type="radio" name='face' value='7'/><img src="<?php echo $GLOBALS['cfg_templets_skin']; ?>/images/mood/ico-mood-7.gif" /></li>
			</ul>
		</div>
		<div class="c"></div>
		<table>
				<tr>
				<td>��֤�룺</td>
			 	<td><input name="validate" type="text" id="validate" size="10" style="height:16px;width:60px;" class="ip" /></td>
			 	<td><img src='../include/vdimgck.php' width='60px' height='20px'  /></td>
       	<td>&nbsp;<input name="sbbt" type="submit" value="��������" style="width:60px;height:22px"  /></td>
			 	<td><input name="notuser" type="checkbox" id="notuser" value="1" />��������</td>
			 </tr>
		</table>
	</div>
</form>
	<div class="c" style="height:30px;"></div>
</div>
<!-- //���۽��� -->
        
        <div class="clearfix"></div>
      </dd>
    </dl>
  </div>
</div>
<?php include $this->CompilerInclude("footer.htm");
 ?>
</body>
</html>