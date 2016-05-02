var compressor = require('node-minify');

new compressor.minify({
	type: "yui-js",
	fileIn: "unpacked/grapher.js",
	fileOut: "grapher.min.js",
	callback: function(err, min) { console.log(err + " done"); }
});
