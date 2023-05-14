//today news tag
function doobject(oID){return document.getElementById(oID)}
function change(oD,oN,oS){
for(i=1;i<oN+1;i++)
{  
doobject("t"+oD+"_"+i).className="tag tag_off";
doobject("d"+oD+"_"+i).style.display="none";
}
doobject("t"+oD+"_"+oS).className="tag tag_on";
doobject("d"+oD+"_"+oS).style.display="block";
}