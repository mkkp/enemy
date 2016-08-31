<?php
$config = include __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

$repo   = \Mkkp\Enemy\Repository::create($config['enemy_repo_file']);
$enemy  = $repo->getEnemyByUri($_SERVER['REQUEST_URI']);
if (empty($enemy)) {
	$enemy = $repo->getRandom();
	header("Location: /".$enemy->indexesString());
	die();
}

?>

<!DOCTYPE html>
<html lang="hu" prefix="og: http://ogp.me/ns#">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="A mai ellenségünk: <?= $enemy->toString() ?>">
	<meta name="author" content="">

	<title>Minden napra új ellenséget!</title>

	<!-- Bootstrap core CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:800&subset=latin-ext" rel="stylesheet">
    <link href="/css/custom.css" rel="stylesheet">
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="Minden napra új ellenséget!"/>
	<meta property="og:description" content="A mai ellenségünk: <?= $enemy->toString() ?>"/>
    <meta property="og:url" content="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" />
	<meta property="og:image" content="<?= "http://$_SERVER[HTTP_HOST]/image/" . sprintf('%s.png', $enemy->indexesString('_')) ?>"/>
	<meta property="og:image:width" content="1140"/>
	<meta property="og:image:height" content="596"/>


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<div id="fb-root"></div>
<div class="main container-fluid">
    <div class="content">
        <article>
            <h1>Minden napra új ellenséget!</h1>
            <div class="imgcontainer col-xs-12 col-sm-12 col-md-8">
                <img src="<?= "http://$_SERVER[HTTP_HOST]/image/" . sprintf('%s.png', $enemy->indexesString('_')) ?>" alt="<?= $enemy->toString() ?>">
            </div>
        </article>
        <button class="btn btn-lg btn-info">Új ellenséget szeretnék</button>
        <div id="share" class="btn">
            <div class="fb-share-button" data-href="<?= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>" data-layout="button" data-size="large" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="<?= urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]") ?>F&amp;src=sdkpreparse">Megosztás</a></div>
        </div>
    </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/js/enemy.js"></script>
<script>
<?php
print 'enemy.parts = ' . $repo->toJSArray() .';';
?>
</script>
<script>
	window.fbAsyncInit = function () {
		FB.init({
			appId: '<?= $config['facebook_app_id'] ?>',
			xfbml: true,
			version: 'v2.7'
		});
	};

	(function (d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) {
			return;
		}
		js = d.createElement(s);
		js.id = id;
		js.src = "//connect.facebook.net/hu_HU/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>