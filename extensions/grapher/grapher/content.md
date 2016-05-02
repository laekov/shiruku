<p>Grapher</p>
<p>Help yourself</p>

<div id='grapherdiv'>
<div>
<label>x range</label>
<input id='xmin' type='text' width='30px' value='-10'/>
~
<input id='xmax' type='text' width='30px' value='10'/>
<br/>
<label>y range</label>
<input id='ymin' type='text' width='30px' value='-8'/>
~
<input id='ymax' type='text' width='30px' value='8'/>
</div>

<div>
<label>y-x functions (Javascript format, separate with ;)</label><br/>
<textarea style='width:512' height='3' id='rtfunc'>Math.pow(Math.E,x);</textarea><br/>
<label>&rho;-&theta; functions (use t for &theta;)</label><br/>
<textarea style='width:512' height='3' id='polfunc'>1-Math.sin(t);</textarea><br/>
<button id='paintit'>Paint</button>
</div>

<canvas id='cloth' height='2048px' width='2560px'>JS not supported</canvas>
</div>

<script> 
var Grapher=function(b){var a=this;this.range={xMin:-10,xMax:10,yMin:-5,yMax:5,};this.colors={bg:"#fff",text:"#000",axisMain:"#333",axisAid:"#eee",curves:["#f00","#f80","#880","#0f0","#0ff","#00f","#80f"],};this.axis={aidXGap:100,aidYGap:100};this.style={fontSize:24};this.xMath2Cvs=function(c){if(c<a.range.xMin||c>a.range.xMax){return false}return(c-a.range.xMin)/(a.range.xMax-a.range.xMin)*a.width};this.xCvs2Math=function(c){return c/a.width*(a.range.xMax-a.range.xMin)+a.range.xMin};this.yMath2Cvs=function(c){if(c<a.range.yMin||c>a.range.yMax){return false}return(a.range.yMax-c)/(a.range.yMax-a.range.yMin)*a.height};this.yCvs2Math=function(c){return a.range.yMax-c/a.height*(a.range.yMax-a.range.yMin)};this.round2=function(c){return Math.round(c*100)/100};a.setRange=function(d,c,f,e){if(d>c){d^=c;c^=d;d^=c}a.range.xMin=d;a.range.xMax=c;if(f>e){f^=e;e^=f;f^=e}a.range.yMin=f;a.range.yMax=e};this.drawLine=function(d,k,c,j,g){var i=a.xMath2Cvs(d);var h=a.xMath2Cvs(c);var f=a.yMath2Cvs(k);var e=a.yMath2Cvs(j);if(i===false||h===false||f===false||e===false){return}a.ctx.beginPath();a.ctx.strokeStyle=g;a.ctx.moveTo(i,f);a.ctx.lineTo(h,e);a.ctx.stroke()};this.drawText=function(e,g,c,h){var d=a.xMath2Cvs(e);if(d<a.style.fontSize){d=a.style.fontSize}if(d>a.width-a.style.fontSize){d=a.width-a.style.fontSize}var f=a.yMath2Cvs(g);if(f<a.style.fontSize){f=20}if(f>a.width-a.style.fontSize){f=a.width-10}a.ctx.font=a.style.fontSize+"px Verdana";a.ctx.fillStyle=c;a.ctx.fillText(h,d,f)};this.clear=function(){a.ctx.fillStyle=a.colors.bg;a.ctx.fillRect(0,0,this.width,this.height)};this.drawAxis=function(){a.drawLine(0,a.range.yMin,0,a.range.yMax,a.colors.axisMain);a.drawText(0,a.range.yMax,a.colors.text,"y");for(var d=0;d<a.width;d+=a.axis.aidXGap){var c=a.xCvs2Math(d);if(Math.abs(d-a.xMath2Cvs(0))>=a.axis.aidXGap){a.drawLine(c,a.range.yMin,c,a.range.yMax,a.colors.axisAid);a.drawText(c,a.range.yMin,a.colors.text,String(a.round2(c)))}}a.drawLine(a.range.xMin,0,a.range.xMax,0,a.colors.axisMain);a.drawText(a.range.xMax,0,a.colors.text,"x");for(var f=0;f<a.height;f+=a.axis.aidYGap){var e=a.yCvs2Math(f);if(Math.abs(f-a.yMath2Cvs(0))>=a.axis.aidYGap){a.drawLine(a.range.xMin,e,a.range.xMax,e,a.colors.axisAid);a.drawText(a.range.xMin,e,a.colors.text,String(a.round2(e)))}}};this.drawFunction=function(l,k,g){var j;if(typeof(l)=="function"){j=l}else{if(typeof(l)=="string"){if(k=="rt"){j=new Function("x","return "+l+";")}else{if(k=="pol"){j=new Function("t","return "+l+";")}}}}if(typeof(g)=="number"){g=a.colors.curves[g]}else{if(g===undefined){g=a.colors.curves[0]}}a.ctx.strokeStyle=g;var i=false;var e=function(f,p){if(f!==false&&p!==false){if(!i){a.ctx.beginPath();a.ctx.moveTo(f,p);i=true}else{a.ctx.lineTo(f,p)}}else{a.ctx.stroke();i=false}};if(k=="rt"){for(var h=0;h<=a.width;++h){var n=a.xCvs2Math(h);var m=j(n);var d=a.yMath2Cvs(m);e(h,d)}}else{if(k=="pol"){for(var o=0,q=Math.PI/(a.width+a.height);o<Math.PI*2;o+=q){var c=j(o);var n=c*Math.cos(o);var h=a.xMath2Cvs(n);var m=c*Math.sin(o);var d=a.yMath2Cvs(m);e(h,d)}}}if(i){a.ctx.stroke()}};this.cvs=b;if(typeof(b)!="object"||typeof(b.getContext)!="function"){this.error="Canvas error";return}this.ctx=b.getContext("2d");if(typeof(this.ctx)!="object"){this.error="Context error";return}this.height=b.height;this.width=b.width};var GrapherController=function(a){var b=this;this.divEle=$(a);this.cvsEle=b.divEle.find("#cloth");this.cvsObj=b.cvsEle.get()[0];this.cvsRat=b.cvsObj.height/b.cvsObj.width;b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height(window.innerHeight-100);$(window).resize(function(){b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height((b.divEle.width()-10)*b.cvsRat);console.log(b.cvsRat)});this.grapher=new Grapher(b.cvsObj);this.redraw=function(){b.grapher.clear();b.grapher.drawAxis()};this.readRange=function(){var d=Number(b.divEle.find("#xmin").val());var c=Number(b.divEle.find("#xmax").val());var f=Number(b.divEle.find("#ymin").val());var e=Number(b.divEle.find("#ymax").val());b.grapher.setRange(d,c,f,e)};this.readFuncs=function(){var e=b.divEle.find("#rtfunc").val().split(";");for(var d in e){b.grapher.drawFunction(e[d],"rt",d%7)}var c=b.divEle.find("#polfunc").val().split(";");for(var d in c){b.grapher.drawFunction(c[d],"pol",(e.length+d)%7)}};b.readRange();b.redraw();b.divEle.find("#paintit").click(function(){b.readRange();b.redraw();b.readFuncs()})};
</script>
<script>var grapher = new GrapherController("#grapherdiv");</script>

