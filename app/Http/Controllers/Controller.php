<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @SWG\Swagger(
 *   basePath="/",
 *   @SWG\Info(
 *     title="D'Casas App",
 *     version="1.0.0",
 *   ),
 *   @SWG\SecurityScheme(
 *      securityDefinition="oauth2", type="oauth2", description="OAuth2 Implicit Grant", flow="implicit",
 *      authorizationUrl="/oauth/authorize",
 *      tokenUrl="/oauth/token",
 *      scopes={"scope": "Login to our system"}
 *     )
 * )
 * This class should be parent class for other API controllers
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param $model
     * @return mixed
     */
    public function getRecords($model)
    {
        $req = app('Illuminate\Http\Request');
        $no_paginate = $req->input('no_paginate');
        $per_page = $req->input('per_page');

        $data =  ($no_paginate) ?
            $model->get() : $model->paginate($per_page);

        return $this->filter($data);
    }

    public function filter($model)
    {
        dd($model);
    }
}
