<?php
if (!defined('srkVersion')) {
	exit(403);
}

function generateSlides($mdPath, $slidesPath) {
	system('pandoc -s --slide-level 1 -t slidy \
		-V slidy-url=https://laekov.com.cn/l/slidy \
		-c https://laekov.com.cn/l/slidy/styles/github.css \
		--highlight-style=kate '.$mdPath.' -o '.$slidesPath);
}

