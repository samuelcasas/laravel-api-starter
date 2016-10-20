<?php

namespace App\Http\Controllers;

use InfyOm\Generator\Utils\ResponseUtil;
use Response;

/**
 * @SWG\Swagger(
 *   basePath="/",
 *   @SWG\Info(
 *     title="App Name",
 *     version="1.0.0",
 *   ),
 *      @SWG\SecurityScheme(
 *         securityDefinition="oauth2", type="oauth2", description="OAuth2 Implicit Grant", flow="implicit",
 *         authorizationUrl="https://example.org/oauth/authorize",
 *         tokenUrl="/oauth/token",
 *         scopes={"scope": "Description of scope."}
 *     )
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */


class AppBaseController extends Controller
{}
