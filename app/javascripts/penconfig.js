function checkPenConfig(id, cfg) {
	if (cfg.id == undefined) {
		cfg.id = id;
	}
	if (cfg.title == undefined) {
		cfg.title = id;
	}
	if (cfg.priority == undefined) {
		cfg.priority = (cfg.modifyTime == undefined) ? Math.random() : cfg.modifyTime;
	}
	return cfg;
}
