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
</script>
<script>var grapher = new GrapherController("#grapherdiv");</script>

