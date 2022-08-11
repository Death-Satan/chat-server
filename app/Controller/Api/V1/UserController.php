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
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;

class UserController extends BaseController
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->raw('Hello Hyperf!');
    }

    #[PostMapping('/user/login')]
    public function login(RequestInterface $request)
    {
        // 应用code
        $app_code = $request->getAttribute('app_code', null);
//        $app_key = $request->getAttribute('app_key', null);
//        $app_secret = $request->getAttribute('app_secret', null);
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
        $token_generator = $this->container->get(IdGeneratorInterface::class);
        $data = [
            'user_id' => $user->id,
            'token' => md5($token_generator->generate()),
        ];
        $token = UserToken::create($data);
        return $this->result->success([
            'token' => $token->token,
        ]);
    }

    #[PostMapping('/user/reg')]
    public function reg(RequestInterface $request)
    {
        $account = $request->getAttribute('account');
        $avatar = $request->getAttribute('avatar');
        $login_ip = '127.0.0.1';
        $login_time = Carbon::now();
        $app_code = $request->getAttribute('app_code');
        $application = Application::where('app_code', $app_code)->first();
        if (empty($application)) {
            return $this->result->error([], '应用不存在');
        }
        $app_id = $application->id;
        $user = User::create(compact('account', 'app_id', 'login_ip', 'login_time', 'avatar'));
        $token_generator = $this->container->get(IdGeneratorInterface::class);
        $data = [
            'user_id' => $user->id,
            'token' => md5($token_generator->generate()),
        ];
        $token = UserToken::create($data);
        return $this->result->success([
            'token' => $token->token,
        ]);
    }

}
