<?php 
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

	$app->get('/{width}/{height}', function(Request $request, Silex\Application $app, $width, $height){
		// echo "Here it is";
		$query = $request->get('image') ? "where id=?" : "order by rand() limit 1";
		$image = $app['db']->fetchAssoc("Select filename from images {$query}", [$request->get('image')]);
		// var_dump($image);
		// die;
		$placeholder = $app['cache']->fetch($cacheKey = "{$width}:{$height}:{$request->get('image')}");
		if ($placeholder === false) {
			$placeholder = $app['image']->make(__DIR__ .'/../public/img/'.$image['filename'])
			// ->fit($width, $height)
			->resize($width, $height)
			// ->height($height)
			->greyscale()
			->response('png');	
			$app['cache']->store($cacheKey, $placeholder);
		}

		return new Response($placeholder, 200, [
				'Content-type' => 'image/png'
			]);
	})->assert('width', '[0-9]+')->assert('height', '[0-9]+');
?>