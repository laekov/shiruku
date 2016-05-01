var Grapher = function(cvs) {
	var self = this;

	this.cvs = cvs;
	this.height = cvs.height;
	this.width = cvs.width;

	this.range = {
		xMin: -10, xMax: 10,
		yMin: -5, yMax: 5,
	};
	this.colors = {
		bg: "#fff",
		text: "#000",
		axisMain: "#333", axisAid: "#eee",
		curves: ["#f00", "#f80", "#880", "#0f0", "#0ff", "#00f", "#80f"],
	};
	this.axis = {
		aidXGap: 100, aidYGap: 100
	};

	this.xMath2Cvs = function(x) {
		if (x < self.range.xMin || x > self.range.xMax) { return false; }
		return (x - self.range.xMin) / (self.range.xMax - self.range.xMin) * self.width;
	}
	this.xCvs2Math = function(cx) {
		return cx / self.width * (self.range.xMax - self.range.xMin) + self.range.xMin;
	}
	this.yMath2Cvs = function(y) {
		if (y < self.range.yMin || y > self.range.yMax) { return false; }
		return (self.range.yMax - y) / (self.range.yMax - self.range.yMin) * self.height;
	}
	this.yCvs2Math = function(cy) {
		return self.range.yMax - cy / self.height * (self.range.yMax - self.range.yMin);
	}
	this.round2 = function(x) {
		return Math.round(x * 100) / 100;
	}

	self.setRange(x0, x1, y0, y1) {
		if (x0 > x1) { x0 ^= x1; x1 ^= x0; x0 ^= x1; }
		self.range.xMin = x0;
		self.range.xMax = x1;
		if (y0 > y1) { y0 ^= y1; y1 ^= y0; y0 ^= y1; }
		self.range.yMin = y0;
		self.range.yMax = y1;
	}

	this.drawLine = function(x0, y0, x1, y1, color) {
		var cx0 = self.xMath2Cvs(x0);
		var cx1 = self.xMath2Cvs(x1);
		var cy0 = self.yMath2Cvs(y0);
		var cy1 = self.yMath2Cvs(y1);
		if (cx0 === false || cx1 === false || cy0 === false || cy1 === false) { return; }
		self.ctx.beginPath();
		self.ctx.strokeStyle = color;
		self.ctx.moveTo(cx0, cy0);
		self.ctx.lineTo(cx1, cy1);
		self.ctx.stroke();
	}
	this.drawText = function(x0, y0, color, word) {
		var cx0 = self.xMath2Cvs(x0);
		if (cx0 < 10) { cx0 = 10; }
		if (cx0 > self.width - 10) { cx0 = self.width - 10; }
		var cy0 = self.yMath2Cvs(y0);
		if (cy0 < 10) { cy0 = 10; }
		if (cy0 > self.width - 10) { cy0 = self.width - 10; }
		self.ctx.font = "11px Verdana";
		self.ctx.fillstyle = color;
		self.ctx.fillText(word, cx0, cy0);
	}

	this.clear = function() {
		self.ctx.fillStyle = self.colors.bg;
		self.ctx.fillRect(0, 0, this.width, this.height);
	}

	this.drawAxis = function() {
		self.drawLine(0, self.range.yMin, 0, self.range.yMax, self.colors.axisMain);
		self.drawText(0, self.range.yMax, self.colors.text, "y");
		for (var cx = 0; cx < self.width; cx += self.axis.aidXGap) {
			var x = self.xCvs2Math(cx);
			if (Math.abs(cx - self.xMath2Cvs(0)) >= self.axis.aidXGap) {
				self.drawLine(x, self.range.yMin, x, self.range.yMax, self.colors.axisAid);
				self.drawText(x, self.range.xMin, self.colors.text, String(self.round2(x)));
			}
		}
		self.drawLine(self.range.xMin, 0, self.range.xMax, 0, self.colors.axisMain);
		self.drawText(self.range.xMax, 0, self.colors.text, "x");
		for (var cy = 0; cy < self.height; cy += self.axis.aidYGap) {
			var y = self.yCvs2Math(cy);
			if (Math.abs(cy - self.yMath2Cvs(0)) >= self.axis.aidYGap) {
				self.drawLine(self.range.xMin, y, self.range.xMax, y, self.colors.axisAid);
				self.drawText(self.range.xMin, y, self.colors.text, String(self.round2(y)));
			}
		}
	}
	this.drawFunction = function(fun, color) {
		var f;
		if (typeof(fun) == 'function') {
			f = fun;
		}
		else if (typeof(fun) == 'string') {
			f = new Function("x", "return " + fun + ";");
		}
		if (typeof(color) == 'number') {
			color = self.colors.curves[color];
		}
		else if (color === undefined) {
			color = self.colors.curves[0];
		}
		self.ctx.strokeStyle = color;
		for (var cx = 0, continuous = false; cx <= self.width; ++ cx) {
			var x = self.xCvs2Math(cx);
			var y = f(x);
			var cy = self.yMath2Cvs(y);
			if (cy !== false) {
				if (!continuous) {
					self.ctx.beginPath();
					self.ctx.moveTo(cx, cy);
					continuous = true;
				}
				else { self.ctx.lineTo(cx, cy); }
			}
			else { 
				self.ctx.stroke();
				continuous = false; 
			}
		}
		self.ctx.stroke();
	}

	if (typeof(cvs) != 'object' || typeof(cvs.getContext) != 'function') {
		this.error = 'Canvas error';
		return;
	}
	this.ctx = cvs.getContext("2d");
	if (typeof(this.ctx) != 'object') {
		this.error = 'Context error';
		return;
	}
}

