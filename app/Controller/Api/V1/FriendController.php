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
use App\Model\Friend;
use App\Model\User;
use Hyperf\HttpServer\Annotation\Controller;

#[Controller]
class FriendController extends BaseController
{
    public function add()
    {
        $app_code = $this->request->getAttribute('app_code', null);
//        $app_key = $this->request->post('app_key', null);
//        $app_secret = $this->request->post('app_secret', null);
        $application = Application::where('app_code', $app_code)->first();
        if (empty($application)) {
            return $this->result->error([], '应用不存在');
        }
        $app_id = $application->id;
        $form_account = $this->request->getAttribute('form_account');
        $to_account = $this->request->getAttribute('to_account');
        $form_user = User::where('account', $form_account)->first();
        $to_user = User::where('account', $to_account)->first();
        if (empty($form_user) || empty($to_user)) {
            return $this->result->error([], '用户不存在');
        }
        $status = 1;
        $form_id = $form_user->id;
        $to_id = $to_user->id;
        Friend::create(compact(
            'app_id',
            'to_id',
            'form_id',
            'status'
        ));
        return $this->result->success();
    }
}
