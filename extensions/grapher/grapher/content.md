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
<input id='ymin' type='text' width='30px' value='-5'/>
~
<input id='ymax' type='text' width='30px' value='5'/>
</div>

<div>
<label>Value (Javascript format, separate with ;)</label><br/>
<textarea style='width:512' height='3' id='srctext'></textarea><br/>
<button id='paintit'>Paint</button>
</div>

<canvas id='cloth' height='2048px' width='2560px'>JS not supported</canvas>
</div>

<script> 
var Grapher=function(b){var a=this;this.range={xMin:-10,xMax:10,yMin:-5,yMax:5,};this.colors={bg:"#fff",text:"#000",axisMain:"#333",axisAid:"#eee",curves:["#f00","#f80","#880","#0f0","#0ff","#00f","#80f"],};this.axis={aidXGap:100,aidYGap:100};this.style={fontSize:24};this.xMath2Cvs=function(c){if(c<a.range.xMin||c>a.range.xMax){return false}return(c-a.range.xMin)/(a.range.xMax-a.range.xMin)*a.width};this.xCvs2Math=function(c){return c/a.width*(a.range.xMax-a.range.xMin)+a.range.xMin};this.yMath2Cvs=function(c){if(c<a.range.yMin||c>a.range.yMax){return false}return(a.range.yMax-c)/(a.range.yMax-a.range.yMin)*a.height};this.yCvs2Math=function(c){return a.range.yMax-c/a.height*(a.range.yMax-a.range.yMin)};this.round2=function(c){return Math.round(c*100)/100};a.setRange=function(d,c,f,e){if(d>c){d^=c;c^=d;d^=c}a.range.xMin=d;a.range.xMax=c;if(f>e){f^=e;e^=f;f^=e}a.range.yMin=f;a.range.yMax=e};this.drawLine=function(d,k,c,j,g){var i=a.xMath2Cvs(d);var h=a.xMath2Cvs(c);var f=a.yMath2Cvs(k);var e=a.yMath2Cvs(j);if(i===false||h===false||f===false||e===false){return}a.ctx.beginPath();a.ctx.strokeStyle=g;a.ctx.moveTo(i,f);a.ctx.lineTo(h,e);a.ctx.stroke()};this.drawText=function(e,g,c,h){var d=a.xMath2Cvs(e);if(d<a.style.fontSize){d=a.style.fontSize}if(d>a.width-a.style.fontSize){d=a.width-a.style.fontSize}var f=a.yMath2Cvs(g);if(f<a.style.fontSize){f=20}if(f>a.width-a.style.fontSize){f=a.width-10}a.ctx.font=a.style.fontSize+"px Verdana";a.ctx.fillStyle=c;a.ctx.fillText(h,d,f)};this.clear=function(){a.ctx.fillStyle=a.colors.bg;a.ctx.fillRect(0,0,this.width,this.height)};this.drawAxis=function(){a.drawLine(0,a.range.yMin,0,a.range.yMax,a.colors.axisMain);a.drawText(0,a.range.yMax,a.colors.text,"y");for(var d=0;d<a.width;d+=a.axis.aidXGap){var c=a.xCvs2Math(d);if(Math.abs(d-a.xMath2Cvs(0))>=a.axis.aidXGap){a.drawLine(c,a.range.yMin,c,a.range.yMax,a.colors.axisAid);a.drawText(c,a.range.yMin,a.colors.text,String(a.round2(c)))}}a.drawLine(a.range.xMin,0,a.range.xMax,0,a.colors.axisMain);a.drawText(a.range.xMax,0,a.colors.text,"x");for(var f=0;f<a.height;f+=a.axis.aidYGap){var e=a.yCvs2Math(f);if(Math.abs(f-a.yMath2Cvs(0))>=a.axis.aidYGap){a.drawLine(a.range.xMin,e,a.range.xMax,e,a.colors.axisAid);a.drawText(a.range.xMin,e,a.colors.text,String(a.round2(e)))}}};this.drawFunction=function(e,g){var i;if(typeof(e)=="function"){i=e}else{if(typeof(e)=="string"){i=new Function("x","return "+e+";")}}if(typeof(g)=="number"){g=a.colors.curves[g]}else{if(g===undefined){g=a.colors.curves[0]}}a.ctx.strokeStyle=g;var h=false;for(var d=0;d<=a.width;++d){var c=a.xCvs2Math(d);var k=i(c);var j=a.yMath2Cvs(k);if(j!==false){if(!h){a.ctx.beginPath();a.ctx.moveTo(d,j);h=true}else{a.ctx.lineTo(d,j)}}else{a.ctx.stroke();h=false}}if(h){a.ctx.stroke()}};this.cvs=b;if(typeof(b)!="object"||typeof(b.getContext)!="function"){this.error="Canvas error";return}this.ctx=b.getContext("2d");if(typeof(this.ctx)!="object"){this.error="Context error";return}this.height=b.height;this.width=b.width};var GrapherController=function(a){var b=this;this.divEle=$(a);this.cvsEle=b.divEle.find("#cloth");this.cvsObj=b.cvsEle.get()[0];this.cvsRat=b.cvsObj.height/b.cvsObj.width;b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height(window.innerHeight-100);$(window).resize(function(){b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height((b.divEle.width()-10)*b.cvsRat)});this.grapher=new Grapher(b.cvsObj);this.redraw=function(){b.grapher.clear();b.grapher.drawAxis()};this.readRange=function(){var d=Number(b.divEle.find("#xmin").val());var c=Number(b.divEle.find("#xmax").val());var f=Number(b.divEle.find("#ymin").val());var e=Number(b.divEle.find("#ymax").val());b.grapher.setRange(d,c,f,e)};this.readFuncs=function(){var d=b.divEle.find("#srctext").val().split(";");for(var c in d){b.grapher.drawFunction(d[c],c%7)}};b.readRange();b.redraw();b.divEle.find("#paintit").click(function(){b.readRange();b.redraw();b.readFuncs()})};
</script>
<script>var grapher = new GrapherController("#grapherdiv");</script>

