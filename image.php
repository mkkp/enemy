<?php
$config = include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$repo   = \Mkkp\Enemy\Repository::create($config['enemy_repo_file']);
$enemy  = $repo->getEnemyByUri($_SERVER['REQUEST_URI']);
if (empty($enemy)) {
	die();
}

$file = sprintf('%s.png', $enemy->indexesString('_'));

\Mkkp\Enemy\Billboard::createFromBaseImage(
	$config['billboard']['base'],
	$config['billboard']['font']
)
	->drawText($config['billboard']['title'], $config['billboard']['color_title'], -75)
	->drawText($enemy->toString(), $config['billboard']['color_enemy'], 25)
	->save($config['billboard']['save_to'] . DIRECTORY_SEPARATOR . $file)
	->show();
