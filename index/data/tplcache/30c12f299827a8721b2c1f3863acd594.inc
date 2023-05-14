<li><a href="[field:arcurl /]" target="_blank">[field:title /]</a><span>¡¡¡¡[field:pubdate function="GetDateTimeMK(@me)"/]</span></li>
            [field:global name='autoindex' runphp="yes"]
            if(@me%5==0) @me="<div class='mylist'></div>";
            else @me="";
            [/field:global]