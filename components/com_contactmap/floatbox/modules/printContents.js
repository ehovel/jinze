/* Floatbox v3.54.1 */
Floatbox.prototype.printContents=function(a){var n=this;n.exec(n.currentItem,"onPrint");if(n.exec(n.currentItem,"beforePrint")==="false"){return}var b=fb.lastChild.fbContent,m='<style type="text/css">html,body{border:0;margin:0;padding:0;}</style>',k=fb.lastChild.pos.fbMainDiv,c=window.open("","","width="+k.width+",height="+k.height),j=c&&c.document;if(!j){alert("Popup windows are being blocked by your browser.\nUnable to print.");return false}if(b.nodeName==="IFRAME"){var f=b.contentDocument||(b.contentWindow&&b.contentWindow.document);var l=f.getElementsByTagName("body")[0],g='<div style="'+(l.getAttribute("style")||"")+'">'+l.innerHTML+"</div>";for(var o in {link:"",style:""}){var d=f.getElementsByTagName(o);for(var e=0,h=d.length;e<h;e++){m+=n.getOuterHTML(d[e])}}}else{var g="<div>"+n.getOuterHTML(b)+"</div>"}if(/\.css$/i.test(a)){m+='<link rel="stylesheet" type="text/css" href="'+a+'" />'}else{if(a){m+='<style type="text/css">'+(a||"")+"</style>"}}j.open("text/html");j.write("<!DOCTYPE html><html><head>"+m+"</head><body onunload=\"window.opener.fb.lastChild.exec(window.opener.fb.lastChild.currentItem, 'afterPrint');\">"+g+'<script type="text/javascript">setTimeout(function() { document.getElementsByTagName("body")[0].focus(); print(); close(); }, 400);<\/script></body></html>');j.close()};