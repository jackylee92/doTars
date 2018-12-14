<?php
namespace src\component;
use Tars\core\Request;
use Tars\core\Response;
class Controller
{
    protected $request;
    protected $response;
    public function __construct(Request $request, Response $response)
    {
        // 验证cookie、get参数、post参数、文件上传
        $this->request = $request;
        $this->response = $response;
    }
    public function getResponse()
    {
        return $this->response;
    }
    public function getRequest()
    {
        return $this->request;
    }
    public function cookie($key, $value = '', $expire = 0, $path = '/', $domain = '', $secure = false, $httponly = false)
    {
        $this->response->cookie($key, $value, $expire, $path, $domain, $secure, $httponly);
    }
    // 给客户端发送数据
    public function sendRaw($result)
    {
        $this->response->send($result);
    }
    public function header($key, $value)
    {
        $this->response->header($key, $value);
    }
    public function status($http_status_code)
    {
        $this->response->status($http_status_code);
    }
	public function returnJson($data)
    {
        return $this->sendRaw(json_encode($data,JSON_UNESCAPED_UNICODE));
    }
	   /**
     * @Content : 获取请求类型
     * @Param   : request
     * @Return  : string
     * @Author  : lijundong
     * @Time    : 2018/8/9 下午2:47
     *
     */
    public function requestType()
    {
        return $this->request->data['server']['request_method'];
    }

    /**
     * @Content : 获取get参数
     * @Param   : array
     * @Return  : data
     */
    public function requestGetParam()
    {
        return isset($this->request->data['get']) ? $this->request->data['get'] : [];
    }

    /**
     * @Content : 获取post参数
     * @Return  : array
     * @Author  : lijundong
     */
    public function requestPostParam()
    {
        return isset($this->request->data['post']) ? $this->request->data['post'] : [];
    }


}
