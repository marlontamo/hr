<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Loader.php";

require 'vendor/autoload.php';
 
use Illuminate\View;
use Illuminate\Events;
use Illuminate\Filesystem;
 

class MY_Loader extends MX_Loader {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_cached_vars()
	{
		return $this->_ci_cached_vars;
	}

	public function blade($view, array $parameters = array())
	{
		$CI =& get_instance();
		
		// Get paths from configuration
		$viewsPaths = $CI->config->item('views_paths');
		$cachePath = $CI->config->item('cache_path');

		// Create the file system objects
		$fileSystem = new Filesystem\Filesystem();
		$fileFinder = new View\FileViewFinder($fileSystem, $viewsPaths);
		 
		// Create the Blade engine and register it
		$bladeEngine = new View\Engines\CompilerEngine(
		new View\Compilers\BladeCompiler($fileSystem, $cachePath)
		);
		 
		$engineResolver = new View\Engines\EngineResolver();
		$engineResolver->register('blade', function() use ($bladeEngine) {
		return $bladeEngine;
		});
		 
		// Create the environment object
		$environment = new View\Environment(
		$engineResolver,
		$fileFinder,
		new Events\Dispatcher()
		);
		 
		// Create the view
		return new View\View(
			$environment,
			$bladeEngine,
			$view,
			$fileFinder->find($view),
			$parameters
		);
	}

	/**
	 * Model Loader
	 *
	 * This function lets users load and instantiate models.
	 *
	 * @param	string	the name of the class
	 * @param	string	name for the model
	 * @param	bool	database connection
	 * @return	void
	 */
	public function model($model, $name = '', $db_conn = FALSE)
	{
		if (is_array($model))
		{
			foreach ($model as $babe)
			{
				$this->model($babe);
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);

			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		$model = strtolower($model);


		foreach ($this->_ci_model_paths as $mod_path)
		{
			if(CLIENT_DIR != ''){


				$client_mod_path = str_replace('apps/modules', MODPATH.CLIENT_DIR, $mod_path);
			
				if ( file_exists($client_mod_path.'models/'.$path.$model.'.php'))
				{
					$mod_path = $client_mod_path;
					
				}

			}

			if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))
			{
				continue;
			}

			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
			{
				if ($db_conn === TRUE)
				{
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}

			if ( ! class_exists('CI_Model'))
			{
				load_class('Model', 'core');
			}

		/* LOAD CLIENT MODELS */
		if(CLIENT_DIR != ''){
			$client_directories = glob(MODPATH.CLIENT_DIR . '/*' , GLOB_ONLYDIR);
			
			foreach ($client_directories as $key => $directory) {

				if (file_exists($directory.'/models/'.$path.$model.'.php'))
				{
					$mod_path = $directory.'/';

				}else{
					continue;
				}
			}

		}
		/* LOAD CLIENT MODELS */

			require_once($mod_path.'models/'.$path.$model.'.php');

			$model = ucfirst($model);

			$CI->$name = new $model();

			$this->_ci_models[] = $name;
			return;
		}

		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}

	/** Load a module view **/
	public function view($view, $vars = array(), $return = FALSE) {
		list($path, $_view) = Modules::find($view, $this->_module, 'views/');
		
		if ($path != FALSE) {
			if(CLIENT_DIR != '' && is_dir(MODPATH.CLIENT_DIR.'/'.$this->_module.'/views/')){
				$path = str_replace('apps/modules', MODPATH.CLIENT_DIR, $path);
			}
			
			$this->_ci_view_paths = array($path => TRUE) + $this->_ci_view_paths;
			$view = $_view;
		}
		
		return $this->_ci_load(array('_ci_view' => $view, '_ci_vars' => $this->_ci_object_to_array($vars), '_ci_return' => $return));
	}

}