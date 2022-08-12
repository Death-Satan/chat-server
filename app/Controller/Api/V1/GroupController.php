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
use App\Model\Group;
use App\Model\GroupRelation;
use App\Model\User;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\PostMapping;
use Hyperf\Utils\Str;

#[Controller]
class GroupController extends BaseController
{
    #[PostMapping('/group/create')]
    public function create()
    {
        $name = $this->request->post('name');
        $group_name_code = Str::random(32);
        // 应用code
        $app_code = $this->request->getAttribute('app_code', null);
//        $app_key = $this->request->post('app_key', null);
//        $app_secret = $this->request->post('app_secret', null);
        $application = Application::where('app_code', $app_code)->first();
        if (empty($application)) {
            return $this->result->error([], '应用不存在');
        }
        $app_id = $application->id;
        $status = 1;
        $creator = 0;
        $setting = [];
        $group = Group::create(compact('name', 'app_id', 'status', 'setting', 'creator', 'group_name_code'));
        return $this->result->success($group->toArray());
    }

    #[PostMapping('/group/join')]
    public function join(): \Psr\Http\Message\ResponseInterface
    {
        $group_code = $this->request->getAttribute('code');
        $account = $this->request->getAttribute('account');
        $user = User::where('account', $account)->first();
        $group = Group::where('group_name_code', $group_code)->first();
        if (empty($user) || empty($group)) {
            return $this->result->error([], '不存在');
        }
        $group_relation = GroupRelation::create([
            'user_id'=>$user->id,
            'group_id'=>$group->id,
        ]);
        return $this->result->success();
    }
}
