<?php
$z[0]=Array("global","",236,264);
$z[0][4]['name']="cfg_soft_lang";
$z[1]=Array("field","",277,296);
$z[1][4]['name']="title";
$z[2]=Array("global","",297,323);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("field","",364,393);
$z[3][4]['name']="keywords";
$z[4]=Array("field","",433,491);
$z[4][4]['name']="description";
$z[4][4]['function']="html2text(@me)";
$z[5]=Array("global","",509,538);
$z[5][4]['name']="cfg_templeturl";
$z[6]=Array("include","",647,682);
$z[6][4]['filename']="head.htm";
$z[7]=Array("global","",833,858);
$z[7][4]['name']="cfg_cmsurl";
$z[8]=Array("field","",915,935);
$z[8][4]['name']="title";
$z[9]=Array("list","\r\n				<li>\r\n      				[field:array runphp='yes']@me = (empty(@me['litpic']) ? \"\" : \"<a href='{@me['arcurl']}' class='preview'><img src='{@me['litpic']}'/></a>\"); [/field:array]\r\n					<a href=\"[field:arcurl/]\" class=\"title\">[field:title/]</a>\r\n					<span class=\"info\">\r\n						<small>日期：</small>[field:pubdate function=\"GetDateTimeMK(@me)\"/]\r\n						<small>点击：</small>[field:click/]\r\n						<small>好评：</small>[field:scores/]\r\n					</span>\r\n					<p class=\"intro\">\r\n						[field:description/]...\r\n					</p>\r\n				</li>\r\n",1007,1594);
$z[9][4]['orderby']="sortrank";
$z[9][4]['pagesize']="10";
$z[10]=Array("pagelist","",1700,1771);
$z[10][4]['listitem']="info,index,end,pre,next,pageno";
$z[10][4]['listsize']="5";
$z[11]=Array("arclist","\r\n          	<li><a href=\"[field:arcurl/]\">[field:title/]</a>\r\n            	<p>[field:description function='cn_substr(@me,80)'/]...</p>\r\n            </li>",1992,2202);
$z[11][4]['flag']="c";
$z[11][4]['titlelen']="42";
$z[11][4]['row']="6";
$z[12]=Array("arclist","\r\n                    	<li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                    ",2416,2564);
$z[12][4]['row']="10";
$z[12][4]['orderby']="click";
$z[13]=Array("include","",2648,2685);
$z[13][4]['filename']="footer.htm";

?>