<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>��Ա���� -<?php echo $cfg_webname; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<link href="templets/style/index.css" rel="stylesheet" type="text/css" />
<link href="templets/style/boxy.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="templets/js/j.js"></script>
<script type="text/javascript" src="templets/js/jquery.boxy.js"></script>
<script type="text/javascript" src="templets/js/load_index.js"></script>
<script type="text/javascript" src="templets/js/leftmenu.js"></script>
<script type="text/javascript" src="templets/js/face.js"></script>
<script type="text/javascript" src="templets/js/Dialog.js"></script>
<script type="text/javascript" src="templets/js/jquery.js"></script>
<script type="text/javascript" src="templets/js/feed.js"></script>
<script language='javascript'>
	function msgSubmit(form) {
		//var id=form.id.value;
		var content = form.share_textarea.value;
		if( content == '��,˵��ɶ��...' ) content = '';
		if ( content == '' ) {
			alert('����������'); return false;
		}
		$.ajax({
			type:'POST',
			url:'index_do.php?fmdo=moodmsg&dopost=sendmsg',
			cache:false,
			data:'&content='+encodeURIComponent(content),
			dataType:'json',
			success:function(message){
				if ( message.type == 'success' ) {
					$('#share_textarea').val('');
					$('#moodcontent').html(message.data);
				} else {
					alert(message.data);
				}
			}
		});
	}
</script>
</head>
<body>
<div id="baseParent">
    <div id="mood_face_bg"></div>
	<div id="mood_msg_menu" class="faceBox" style="position: absolute; top: 332px;display: none;">
        <ul>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/1.gif" id="face1" onclick="addFace(1)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/2.gif" id="face2" onclick="addFace(2)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/3.gif" id="face3" onclick="addFace(3)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/4.gif" id="face4" onclick="addFace(4)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/5.gif" id="face5" onclick="addFace(5)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/6.gif" id="face6" onclick="addFace(6)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/7.gif" id="face7" onclick="addFace(7)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/8.gif" id="face8" onclick="addFace(8)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/9.gif" id="face9" onclick="addFace(9)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/10.gif" id="face10" onclick="addFace(10)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/11.gif" id="face11" onclick="addFace(11)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/12.gif" id="face12" onclick="addFace(12)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/13.gif" id="face13" onclick="addFace(13)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/14.gif" id="face14" onclick="addFace(14)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/15.gif" id="face15" onclick="addFace(15)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/16.gif" id="face16" onclick="addFace(16)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/17.gif" id="face17" onclick="addFace(17)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/18.gif" id="face18" onclick="addFace(18)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/19.gif" id="face19" onclick="addFace(19)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/20.gif" id="face20" onclick="addFace(20)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/21.gif" id="face21" onclick="addFace(21)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/22.gif" id="face22" onclick="addFace(22)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/23.gif" id="face23" onclick="addFace(23)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/24.gif" id="face24" onclick="addFace(24)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/25.gif" id="face25" onclick="addFace(25)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/26.gif" id="face26" onclick="addFace(26)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/27.gif" id="face27" onclick="addFace(27)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/28.gif" id="face28" onclick="addFace(28)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/29.gif" id="face29" onclick="addFace(29)"/></li>
            <li><img style="cursor: pointer; position: relative;" src="templets/images/smiley/30.gif" id="face30" onclick="addFace(30)"/></li>

        </ul>
	</div>

</div>
<div id="main">
<?php include(DEDEMEMBER."/templets/head.htm"); ?>
<div id="content" class="w960 clearfix">
  <?php include(DEDEMEMBER."/templets/menu.php"); ?>
  <div class="755">
    <div class="main-wrap">
      <dl class="sns-avatar">
        <dt>
          <div class="s120"> <a href="/member/index.php?uid=<?php echo $cfg_ml->M_LoginID; ?>"><img src="<?php echo $cfg_ml->fields['face']; ?>" width="100" height="100" alt="��������"/></a> </div>
        </dt>
        <dd class="av-index">
          <ul>
            <li class="name"><?php echo $cfg_ml->M_LoginID; ?><span><?php echo $cfg_ml->M_MbType; ?>�û�</span></li>
            <?php
             if(is_array($moodmsg)){
            ?>
            <li class="other" id="moodcontent"><?php echo $moodmsg['msg'];?></li>
            <?php
              } else {
            ?>
             <li class="other" id="moodcontent">��û�и���ǩ�����������������������д</li>
             <?php
             }
             ?>
            <li class="sign"><?php echo $cfg_ml->GetSta($dsql); ?></li>
          </ul>
          <div class="msg">
            <p>����Ϣ: <em> <a href="pm.php?TB_iframe=true&height=600&width=700" title="�ҵĶ���Ϣ" target="_blank"> <?php echo $pms['nums'];?></a> </em> ����: <em> <a href="caicai.php" title="����������"><?php echo $minfos['feedback']; ?></a> </em> �ղ�: <em> <a href="mystow.php" title="�ղؼ�"><?php echo $minfos['stow']; ?></a> </em> ����: <em><a href="javascript:;"><?php echo $minfos['archives']; ?></a> </em> ����:<em> <a href="content_list.php?channelid=1" title="�ѷ���������"><?php echo $minfos['article']; ?></a> </em>ͼ��: <em> <a href="content_list.php?channelid=2" title="����ͼ��"><?php echo $minfos['album']; ?></a> </em> ����: <em> <a href="content_list.php?channelid=3" title="�ѷ���������"><?php echo $minfos['soft']; ?></a> </em> ��Ʒ:</a> <em> <a href="shops_products.php" title="�������Ʒ"><?php echo $minfos['shop']; ?></a> </em> </p>
          </div>
        </dd>
      </dl>
      <div class="share">
        <div class="share01"> </div>
        <div class="share02">
          <form target="hidden_frame" method="post" enctype="multipart/form-data" name="msgmood" action="#">
            <input id="share_textarea" type="text" value="��,˵��ɶ��..." onclick="showFace()"/>
            <button id="btn_submit" type="button" onclick="msgSubmit(this.form)">����</button>
          </form>
        </div>
      </div>
      <div id="sns-feeds">
          <div class="indexTab">
            <ul>
              <li id="arcticle"><a href="javascript:void(0)">�����ĵ�</a></li>
              <li class="thisTab" id="myfeed"><a href="javascript:void(0)">�ҵĶ�̬</a></li>
              <li id="allfeed"><a href="javascript:void(0)">ȫվ��̬</a></li>
            </ul>
          </div>
        <div class="sns-box" id="FeedText"></div>
      </div>
    </div>
    <div class="col-extra">
      <div class="sns-box">
        <div class="hd">
          <h3>��Ϣͳ��</h3>
        </div>
        <div class="sns-avatar-m">
          <dl class="statistics">
            <dt>�ռ��������</dt>
            <dd><?php echo $minfos['homecount']; ?></dd>
            <dt>�ĵ��ܵ����</dt>
            <dd><?php echo $minfos['pagecount']; ?></dd>
            <dt>����������</dt>
            <dd><?php echo $minfos['friend']; ?></dd>
            <dt>�ռ�汾��</dt>
            <dd><?php
       			if($cfg_mb_lit=='Y') echo '�����';
        		else echo '��ȫ��';
        	?></dd>
            <dt>�ϴ����ƣ�</dt>
            <dd><?php echo $cfg_mb_upload_size; ?> KB</dd>
            <dt>�ռ��С��</dt>
            <dd><?php echo $minfos['totaluse']."/".$cfg_mb_max; ?> MB</dd>
          </dl>
        </div>
      </div>
      <div class="sns-box">
        <div class="hd">
          <h3>��ӭ������</h3>
        </div>
        <div class="sns-avatar-m">
          <ul>
            <?php
				foreach ($newfriends as $newfriend)
				{
			 ?>
            <li class="pic"><a target="_blank" href="/member/index.php?uid=<?php echo $newfriend['userid'];?>">
            <?php
            if(!$newfriend['face']==""){
             echo "<img src=".$newfriend['face']." width='48' height='48' />";
            }else{
             if($newfriend['sex']=='Ů') echo "<img src='templets/images/dfgirl.png' width='48' height='48' />";
             else echo "<img src='templets/images/dfboy.png' width='48' height='48' />";
            }
            ?>
            </a><span class="name"><a target="_blank" href="/member/index.php?uid=<?php echo $newfriend['userid'];?>"><?php echo $newfriend['uname'];?></a></span></li>
             <?php
                }
              ?>
          </ul>
        </div>
      </div>
      <div class="clr"></div>
      <div class="sns-box">
        <div class="hd">
          <h3>�ҵĺ���</h3>
        </div>
        <div class="sns-avatar-m">
          <ul>
             <?php
				foreach ($friends as $friend)
				{
			 ?>
            <li class="pic"><a target="_blank" href="/member/index.php?uid=<?php echo $friend['floginid'];?>">
            <?php
            if(!$friend['face']==""){
             echo "<img src=".$friend['face']." width='48' height='48' />";
            }else{
             if($friend['sex']=='Ů') echo "<img src='templets/images/dfgirl.png' width='48' height='48' />";
             else echo "<img src='templets/images/dfboy.png' width='48' height='48' />";
            }
            ?>
            </a><span class="name"><a target="_blank" href="/member/index.php?uid=<?php echo $friend['floginid'];?>"><?php echo $friend['funame'];?></a></span></li>
             <?php
                }
              ?>
          </ul>
        </div>
      </div>
      <div class="sns-box">
        <div class="bd ">
          <form action="search.php">
            <p style="margin-bottom:9px">�����û�</p>
            <input class="text1" type="text" value="" name="keyword"/>
            <button class="button1" type="submit">����</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include(DEDEMEMBER."/templets/foot.htm"); ?>
</div>
</body>
</html>