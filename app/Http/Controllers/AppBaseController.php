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

/**
 * @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="api_key"
 * )
 */

/**
 * @SWG\Get(
 *      path="/oauth/personal-access-tokens",
 *      summary="TODO",
 *      tags={"OAuth"},
 *      description="TODO",
 *      produces={"application/json"},
 *      @SWG\Response(
 *          response=200,
 *          description="successful operation",
 *          @SWG\Schema(
 *              type="object",
 *              @SWG\Property(
 *                  property="success",
 *                  type="boolean"
 *              ),
 *              @SWG\Property(
 *                  property="message",
 *                  type="string"
 *              )
 *          )
 *      )
 * )
 */
class AppBaseController extends Controller
{}
