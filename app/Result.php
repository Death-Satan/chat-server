<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
namespace App;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface;

class Result
{
    #[Inject]
    protected ResponseInterface $response;

    public function systemReturn(int $code = 0, array $data = [], string $msg = ''): \Psr\Http\Message\ResponseInterface
    {
        return $this->response->json(
            compact('code' . 'data', 'msg')
        );
    }

    public function success(array $data = [], string $msg = 'success'): \Psr\Http\Message\ResponseInterface
    {
        return $this->systemReturn(0, $data, $msg);
    }

    public function error(array $data = [], string $msg = 'error'): \Psr\Http\Message\ResponseInterface
    {
        return $this->systemReturn(1, $data, $msg);
    }
}
