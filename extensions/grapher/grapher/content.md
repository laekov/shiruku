<p>Grapher</p>
<p>Help yourself</p>

<div id='grapherdiv'>
<div>
<label>x range</label>
<input id='xmin' type='text' width='30px' value='-5'/>
~
<input id='xmax' type='text' width='30px' value='5'/>
<br/>
<label>y range</label>
<input id='ymin' type='text' width='30px' value='-4'/>
~
<input id='ymax' type='text' width='30px' value='4'/>
</div>

<div>
<label>y-x functions (Javascript format, separate with ;)</label><br/>
<textarea style='width:512' height='3' id='rtfunc'>Math.pow(Math.E,x-3)-Math.PI;</textarea><br/>
<label>&rho;-&theta; functions (use t for &theta;)</label><br/>
<textarea style='width:512' height='3' id='polfunc'>Math.acos(Math.sin(t));</textarea><br/>
<label>parametric functions (use t for param)</label><br/>
<textarea style='width:512' height='3' id='parafunc'>{x:Math.cos(t)*4,y:Math.sin(t)*3,min:0,max:3.14}</textarea><br/>
<button id='paintit'>Paint</button>
<button id='clearit'>Clear</button>
</div>

<canvas id='cloth' height='2048px' width='2560px'>JS not supported</canvas>
</div>

<script> 
var Grapher=function(b){var a=this;this.range={xMin:-10,xMax:10,yMin:-5,yMax:5,};this.colors={bg:"#fff",text:"#000",axisMain:"#333",axisAid:"#eee",curves:["#f00","#f80","#880","#0f0","#0ff","#00f","#80f"],};this.axis={aidXGap:100,aidYGap:100};this.style={fontSize:24};this.xMath2Cvs=function(c){if(c<a.range.xMin||c>a.range.xMax){return false}return(c-a.range.xMin)/(a.range.xMax-a.range.xMin)*a.width};this.xCvs2Math=function(c){return c/a.width*(a.range.xMax-a.range.xMin)+a.range.xMin};this.yMath2Cvs=function(c){if(c<a.range.yMin||c>a.range.yMax){return false}return(a.range.yMax-c)/(a.range.yMax-a.range.yMin)*a.height};this.yCvs2Math=function(c){return a.range.yMax-c/a.height*(a.range.yMax-a.range.yMin)};this.round2=function(c){return Math.round(c*100)/100};a.setRange=function(d,c,f,e){if(d>c){d^=c;c^=d;d^=c}a.range.xMin=d;a.range.xMax=c;if(f>e){f^=e;e^=f;f^=e}a.range.yMin=f;a.range.yMax=e};this.drawLine=function(d,k,c,j,g){var i=a.xMath2Cvs(d);var h=a.xMath2Cvs(c);var f=a.yMath2Cvs(k);var e=a.yMath2Cvs(j);if(i===false||h===false||f===false||e===false){return}a.ctx.beginPath();a.ctx.strokeStyle=g;a.ctx.moveTo(i,f);a.ctx.lineTo(h,e);a.ctx.stroke()};this.drawText=function(e,g,c,h){var d=a.xMath2Cvs(e);if(d<a.style.fontSize){d=a.style.fontSize}if(d>a.width-a.style.fontSize){d=a.width-a.style.fontSize}var f=a.yMath2Cvs(g);if(f<a.style.fontSize){f=20}if(f>a.width-a.style.fontSize){f=a.width-10}a.ctx.font=a.style.fontSize+"px Verdana";a.ctx.fillStyle=c;a.ctx.fillText(h,d,f)};this.clear=function(){a.ctx.fillStyle=a.colors.bg;a.ctx.fillRect(0,0,this.width,this.height)};this.drawAxis=function(){a.drawLine(0,a.range.yMin,0,a.range.yMax,a.colors.axisMain);a.drawText(0,a.range.yMax,a.colors.text,"y");for(var d=0;d<a.width;d+=a.axis.aidXGap){var c=a.xCvs2Math(d);if(Math.abs(d-a.xMath2Cvs(0))>=a.axis.aidXGap){a.drawLine(c,a.range.yMin,c,a.range.yMax,a.colors.axisAid);a.drawText(c,a.range.yMin,a.colors.text,String(a.round2(c)))}}a.drawLine(a.range.xMin,0,a.range.xMax,0,a.colors.axisMain);a.drawText(a.range.xMax,0,a.colors.text,"x");for(var f=0;f<a.height;f+=a.axis.aidYGap){var e=a.yCvs2Math(f);if(Math.abs(f-a.yMath2Cvs(0))>=a.axis.aidYGap){a.drawLine(a.range.xMin,e,a.range.xMax,e,a.colors.axisAid);a.drawText(a.range.xMin,e,a.colors.text,String(a.round2(e)))}}};this.drawFunction=function(m,l,h){var k;if(typeof(m)=="function"){k=m}else{if(typeof(m)=="string"){if(l=="rt"){k=new Function("x","return "+m+";")}else{if(l=="pol"||l=="para"){k=new Function("t","return "+m+";")}}}}if(typeof(h)=="number"){h=a.colors.curves[h]}else{if(h===undefined){h=a.colors.curves[0]}}a.ctx.strokeStyle=h;var j=false;var g=function(f,p){if(f!==false&&p!==false){if(!j){a.ctx.beginPath();a.ctx.moveTo(f,p);j=true}else{a.ctx.lineTo(f,p)}}else{a.ctx.stroke();j=false}};if(l=="rt"){for(var i=0;i<=a.width;++i){var o=a.xCvs2Math(i);var n=k(o);var e=a.yMath2Cvs(n);g(i,e)}}else{if(l=="pol"){for(var q=0,r=Math.PI/(a.width+a.height);q<Math.PI*2;q+=r){var d=k(q);var o=d*Math.cos(q);var i=a.xMath2Cvs(o);var n=d*Math.sin(q);var e=a.yMath2Cvs(n);g(i,e)}}else{if(l=="para"){var c=k(0);var r=r=(c.max-c.min)/(a.width+a.height);for(var q=c.min;q<c.max;q+=r){var d=k(q);var i=a.xMath2Cvs(d.x);var e=a.yMath2Cvs(d.y);g(i,e)}}}}if(j){a.ctx.stroke()}};this.cvs=b;if(typeof(b)!="object"||typeof(b.getContext)!="function"){this.error="Canvas error";return}this.ctx=b.getContext("2d");if(typeof(this.ctx)!="object"){this.error="Context error";return}this.height=b.height;this.width=b.width};var GrapherController=function(a){var b=this;this.divEle=$(a);this.cvsEle=b.divEle.find("#cloth");this.cvsObj=b.cvsEle.get()[0];this.cvsRat=b.cvsObj.height/b.cvsObj.width;b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height((b.divEle.width()-10)*b.cvsRat);$(window).resize(function(){b.cvsEle.width(b.divEle.width()-10);b.cvsEle.height((b.divEle.width()-10)*b.cvsRat)});this.grapher=new Grapher(b.cvsObj);this.redraw=function(){b.grapher.clear();b.grapher.drawAxis()};this.readRange=function(){var d=Number(b.divEle.find("#xmin").val());var c=Number(b.divEle.find("#xmax").val());var f=Number(b.divEle.find("#ymin").val());var e=Number(b.divEle.find("#ymax").val());b.grapher.setRange(d,c,f,e)};this.readFuncs=function(){var f=b.divEle.find("#rtfunc").val().split(";");for(var e in f){b.grapher.drawFunction(f[e],"rt",e%7)}var c=b.divEle.find("#polfunc").val().split(";");for(var e in c){b.grapher.drawFunction(c[e],"pol",(f.length+e)%7)}var d=b.divEle.find("#parafunc").val().split(";");for(var e in d){b.grapher.drawFunction(d[e],"para",(f.length+c.length+e)%7)}};b.readRange();b.redraw();b.divEle.find("#paintit").click(function(){b.readRange();b.redraw();b.readFuncs()});b.divEle.find("#clearit").click(function(){b.divEle.find("#rtfunc").val("");b.divEle.find("#polfunc").val("");b.divEle.find("#parafunc").val("");b.redraw()})};
</script>
<script>var grapher = new GrapherController("#grapherdiv");</script>

