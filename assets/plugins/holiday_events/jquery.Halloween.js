
<!-- Copy and paste between <HEAD>  and  </HEAD> in your HTML -->

<script language="JavaScript1.2">
<!--
  /**
  ** Bats - Halloween -  JavaScript 
  ** This script and many more are free at
  ** http://rainbow.arch.scriptmania.com/scripts/
  */
Bat=new Image();

//////////CONFIGURE THE BATs SCRIPT HERE//////////////////

Bat.src="bat_1.gif";  // Specify path to your bat image
amount=3;  // Number of Bats, minimum must be 3
dismissafter=20;  // Seconds after which Bats should disappear, in seconds
step=0.3;  // Animation speed (smaller is slower)

//////////DO NOT EDIT PAST THIS LINE//////////////////

Xpos=700;  //Bats x coordinates, in pixel
Ypos=200;  //Bats y coordinates, in pixel

var ns6=document.getElementById&&!document.all
bats=new Array(3)
if (document.layers){
for (i=0; i < amount; i++) 
{document.write("<layer name=n"+i+" left=0 top=-50><a href='http://rainbow.arch.scriptmania.com'><img src='"+Bat.src+"' name='nsi' width=69 height=60 border=0></a></layer>")}
}
else if (document.all||ns6){
document.write('<div id="out" style="position:absolute;top:0;left:0"><div id="in" style="position:relative">');
for (i=0; i < amount; i++){
if (document.all)
document.write('<a href="http://rainbow.arch.scriptmania.com"><img src="'+Bat.src+'" id="msieBats" style="position:absolute;top:-50;left:0" border=0></a>')
else
document.write('<a href="http://rainbow.arch.scriptmania.com"><img src="'+Bat.src+'" id="ns6Bats'+i+'" width=69 height=60 style="position:absolute;top:-50;left:0" border=0></a>')
}
document.write('</div></div>');
}

yBase=xBase=currStep=a_count=0;
b_count=1;
c_count=2;
d_count=3;
move=1;
if (document.layers||ns6){
yBase=window.innerHeight/3;
xBase=window.innerWidth/6;
if (document.layers)
window.captureEvents(Event.MOUSEMOVE);

}
if (document.all){
yBase = window.document.body.offsetHeight/3;
xBase = window.document.body.offsetWidth/6;
}

function dismissBat(){
clearInterval(flyBat)
if (document.layers){
for (i2=0; i2 < amount; i2++){
document.layers['n'+i2].visibility="hide"
}
}
else if (document.all)
document.all.out.style.visibility="hidden"
else if (ns6)
document.getElementById("out").style.visibility="hidden"
}

if (document.layers){
for (i=0; i < amount; i++)
document.layers['n'+i].document.images['nsi'].src=Bat.src
}
else if (document.all){
for (i=0; i < amount; i++)
document.all.msieBats[i].src=Bat.src
}
else if (ns6){
for (i=0; i < amount; i++)
document.getElementById("ns6Bats"+i).src=Bat.src
}

function Animate(){
a_count+=move;
b_count+=move;
c_count+=move;
currStep+=step;
if (a_count >= bats.length) a_count=0;
if (b_count >= bats.length) b_count=0;
if (c_count >= bats.length) c_count=0;
if (document.layers){
for (i=0; i < amount; i++) {
  var NewL="n"+i
  document.layers[NewL].top = Ypos+yBase*Math.sin(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/10)
  document.layers[NewL].left =Xpos+xBase*Math.cos(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/62)
  }
}

if (document.all){
for (i=0; i < amount; i++){
  document.all.msieBats[i].style.pixelTop = Ypos+yBase*Math.sin(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/10)
  document.all.msieBats[i].style.pixelLeft =Xpos+xBase*Math.cos(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/62)
 }
}

if (ns6){
for (i=0; i < amount; i++){
  document.getElementById("ns6Bats"+i).style.top = Ypos+yBase*Math.sin(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/10)
  document.getElementById("ns6Bats"+i).style.left =Xpos+xBase*Math.cos(((currStep)+i*3.7)/4)*Math.cos((currStep+i*35)/62)
 }
}

}
flyBat=setInterval('Animate()',30);
setTimeout("dismissBat()",dismissafter*1000)
//-->
</script>
