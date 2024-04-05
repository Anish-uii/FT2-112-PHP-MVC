<?php
class App
{
	private $controller = 'home';
	private $action = 'index';

	public function splitURL()
	{
		$url = $_SERVER['REQUEST_URI'];

		$queryString = '';
		$pos = strpos($url, '?');
		if ($pos !== false) {
			$queryString = substr($url, $pos + 1);
			$url = substr($url, 0, $pos);
		}

		$url = ltrim($url, '/');
		$pos = strpos($url, 'public/');
		if ($pos !== false) {
			$url = substr($url, $pos + strlen('public/'));
		}

		$urlComponents = explode("/", $url);

		if (empty($urlComponents[0])) {
			$urlComponents[0] = "home";
		}

		$urlComponents[] = $queryString;

		return $urlComponents;
	}


	public function loadController()
	{
		$URL = $this->splitURL();
		$fileName = "../app/controllers/" . ucfirst($URL[0]) . ".php";
		if (file_exists($fileName)) {
			require $fileName;
			$this->controller = ucfirst($URL[0]);
		} else {
			$fileName = "../app/controllers/Error404.php";
			require $fileName;
			$this->controller = 'Error404';
		}


		$controller = new $this->controller();


		call_user_func([$controller, $this->action]);
	}
}