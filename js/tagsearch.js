var xmlHttp

function showResult_tag(str, photo, alt)
{
if (str.length==0)
 { 
 document.getElementById("tagsearch").
 innerHTML="";
 document.getElementById("tagsearch").
 style.border="0px";
 return
 }

xmlHttp=GetXmlHttpObject_tag()

if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 

var url="/js/tagsearch.php"
url=url+"?q="+str
url=url+"&alt="+alt
url=url+"&photoId="+photo
url=url+"&sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged_tag 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
} 

function stateChanged_tag() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("tagsearch").
 innerHTML=xmlHttp.responseText;
 document.getElementById("tagsearch").
 style.border="solid 1px #aa567a";

 } 
}

function GetXmlHttpObject_tag()
{
var xmlHttp=null;
try
 {
 // Firefox, Opera 8.0+, Safari
 xmlHttp=new XMLHttpRequest();
 }
catch (e)
 {
 // Internet Explorer
 try
  {
  xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
  }
 catch (e)
  {
  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
 }
return xmlHttp;
}