<div class="layout mt10">

      <div class="c_c_tab">

         <div class="c_c_tab_top">

            <div class="channel_link">{dede:field name='typename'/}</div>

            <div class="c_c_more"><a href="{dede:field name='typeurl'/}" target="_blank">更多>>></a></div>

         </div>

         <div class="c_c_tab_con">

            <div class="c_c_side_l">

               <div class="c_c_focus">

                  {dede:arclist flag='a' row='1' titlelen='34'}

                  <a href="[field:arcurl/]" target="_blank"><img src="[field:litpic/]" width="236" height="271" /></a>

                  <h3><a href="[field:arcurl/]" target="_blank">[field:title/]</a></h3>

                  {/dede:arclist}

               </div>

            </div>

            <div class="c_c_container">

               <ul>

                  {dede:arclist row='12' titlelen='38'}

                  <li><a href="[field:arcurl /]">[field:title /]</a></li>

                  {/dede:arclist}

               </ul>

            </div>

            <div class="c_c_side_r">

               {dede:arclist flag='c' row='1' titlelen='50'}

               <div class="c_c_sidepic">

                  <a href="[field:arcurl/]" target="_blank"><img src="[field:litpic/]" alt="[field:title/]" width="156" height="116" /></a>

                  <h4><a href="[field:arcurl/]" title="[field:title/]" target="_blank">[field:title function="cn_substr(@me,24)"/]</a></h4>

               </div>

               {/dede:arclist}

               {dede:arclist flag='c' limit='1,2' row='1' titlelen='50'}

               <div class="c_c_sidepic mt10">

                  <a href="[field:arcurl/]" target="_blank"><img src="[field:litpic/]" alt="[field:title/]" width="156" height="116" /></a>

                  <h4><a href="[field:arcurl/]" title="[field:title/]" target="_blank">[field:title function="cn_substr(@me,24)"/]</a></h4>

               </div>

               {/dede:arclist}

            </div>

            <div class="clear"></div>   

         </div>

         <div class="clear"></div>   

      </div>

      <div class="c_c_s_tab i_c_s_clothes_tab">

         <div class="c_c_s_img_pack">

            {dede:arclist flag='b' row='1' titlelen='50'}

            <a href="[field:arcurl/]" target="_blank"><img src="[field:litpic/]" alt="[field:title/]" width="156" height="116" />

            <h5><a href="[field:arcurl/]" title="[field:title/]" target="_blank">[field:title function="cn_substr(@me,24)"/]</a></h5>

            {/dede:arclist}

         </div>

         <div class="layout">

            <div class="c_c_s_top c_c_s_clothes_top">精彩专题</div>

            <div class="c_c_s_con">

               <ul>

                  {dede:arclist flag='b' limit='1,9' row='8' titlelen='24'}

                  <li><a href="[field:arcurl/]" target="_blank">[field:title/]</a></li>

                  {/dede:arclist}

               </ul>

            </div>

         </div>

      </div>

      <div class="clear"></div>

   </div>