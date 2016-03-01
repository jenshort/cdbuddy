<?php

namespace SierraSql\Controller;

use SierraSql\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;	
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
	public function index(Request $request, Response $response)
	{
		$template = $this->templates->make('main');
		$template->data([
			'path' => 'payments']);
		$response->setContent($template->render());
		$response->setStatusCode(Response::HTTP_OK);

		return $response;	
	}
}