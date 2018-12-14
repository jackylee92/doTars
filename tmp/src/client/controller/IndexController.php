<?php
namespace src\controller;
use Tars\core\Request;
use Tars\core\Response;
use src\component\Controller;

class IndexController extends Controller
{
    public function __construct(Request $request, Response $response)
    {
	    parent::__construct($request, $response);

    }

    public function actionIndex()
    {
		return $this->returnJson(['code' => '1', 'msg' => 'Success！！']);
    }
}
