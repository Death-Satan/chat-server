<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
namespace App\Controller\Api\V1;

use App\Model\Application;
use App\Model\User;
use App\Model\UserToken;
use Carbon\Carbon;
use Hyperf\Contract\IdGeneratorInterface;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

#[Controller]
class UserController extends BaseController
{

    #[PostMapping('/user/login')]
    public function login(RequestInterface $request)
    {
        // 应用code
        $app_code = $this->request->post('app_code', null);
//        $app_key = $this->request->post('app_key', null);
//        $app_secret = $this->request->post('app_secret', null);
        $application = Application::where('app_code', $app_code)->first();
        if (empty($application)) {
            return $this->result->error([], '应用不存在');
        }
        $app_id = $application->id;
        $account = $this->request->getAttribute('account');
        $user = User::where('account', $account)->where('app_id', $app_id)->first();
        if (empty($user)) {
            return $this->result->error([], '用户id不存在');
        }
        $data = [
            'user_id' => $user->id,
            'token' => md5(uniqid().time()),
        ];
        $token = UserToken::create($data);
        return $this->result->success([
            'token' => $token->token,
        ]);
    }

    #[PostMapping('/user/reg')]
    public function reg(RequestInterface $request)
    {
        $account = $this->request->post('account');
        $avatar = $this->request->post('avatar');
        $login_ip = '127.0.0.1';
        $login_time = Carbon::now();
        $app_code = $this->request->post('app_code');
        $application = Application::where('app_code', $app_code)->first();
        if (empty($application)) {
            return $this->result->error([], '应用不存在');
        }
        $app_id = $application->id;
        $user = User::create(compact('account', 'app_id', 'login_ip', 'login_time', 'avatar'));
        $data = [
            'user_id' => $user->id,
            'token' => md5(uniqid().time()),
            'expire_at'=>Carbon::today()
        ];
        $token = UserToken::create($data);
        return $this->result->success([
            'token' => $token->token,
        ]);
    }

}
