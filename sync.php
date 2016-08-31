<?php

if (php_sapi_name() != 'cli') {
	header('HTTP/1.0 404 Not Found');
	die('404 - Not Found');
}

$config = include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$sheet = \Mkkp\Enemy\Google\SpreadSheet::create(
	$config['spreadsheet']['app_secret'],
	$config['spreadsheet']['token_file']
);

$lists = $sheet->getLists($config['spreadsheet']['id'], $config['spreadsheet']['range']);
$repo  = \Mkkp\Enemy\Repository::create($config['enemy_repo_file']);
$repo->saveLists($lists);

if (isset(getopt('g')['g'])) {
	$result = $repo->getAllCombination();
	foreach ($result as $enemy) {
		$file = $config['billboard']['save_to'] . DIRECTORY_SEPARATOR . sprintf('%s.png', $enemy->indexesString('_'));
		\Mkkp\Enemy\Billboard::createFromBaseImage(
			$config['billboard']['base'],
			$config['billboard']['font']
		)
			->drawText($config['billboard']['title'], $config['billboard']['color_title'], -75)
			->drawText($enemy->toString(), $config['billboard']['color_enemy'], 25)
			->save($file);
	}
}