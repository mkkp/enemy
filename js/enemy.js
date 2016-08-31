var enemy = {
	parts: [],

	init: function () {
		$('button').on('click', enemy.generate);
		var res = /\/(\d+)\/(\d+)\/(\d+)/.exec(window.location.href);
		if (!res) {
			enemy.generate();
			return;
		}
		for (var i = 1; i < 4; i++) {
			if (!(i in res) || enemy.parts[i - 1][res[i]] === undefined) {
				enemy.generate();
				return;
			}
		}
	},

	generate: function () {
		var actualEnemy = '', url  = '/';
		for (var i = 0; i < enemy.parts.length; i++) {
			var rand = Math.floor(Math.random() * enemy.parts[i].length);
			url += rand + '/';
			actualEnemy += enemy.parts[i][rand] + ' ';
		}

		window.location = url;
	}
};

$(document).ready(function () {
	enemy.init()
});
