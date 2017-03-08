<?php 
	namespace App\Providers;
	use Pimple\Container;
	use Pimple\ServiceProviderInterface;
	use Intervention\Image\ImageManager;
	/**
	* Image service provider instance
	*/
	class ImageServiceProvider implements ServiceProviderInterface
	{
		public function register(Container $app){
			$app['image'] = $app->factory(function(){
				return new ImageManager;
			});
		}		
	}
?>