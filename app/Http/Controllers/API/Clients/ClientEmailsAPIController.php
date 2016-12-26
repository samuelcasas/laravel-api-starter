<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Requests\API\CreateTelephoneAPIRequest;
use App\Http\Requests\API\UpdateTelephoneAPIRequest;
use App\Models\Email;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class ClientTelephonesAPIController
 * @package App\Http\Controllers\API
 */

class ClientEmailsAPIController extends Controller
{
    use Helpers;

    /**
     * @param $clientID
     * @return Response
     * @internal param Request $request
     * @SWG\Get(
     *      path="/clients/{clientID}/emails",
     *      summary="Get a listing of the Clients.",
     *      tags={"Client Emails"},
     *      description="Get all Client Emails",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
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
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Email")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index($clientID)
    {
        $email = $this->getModel($clientID)->pimp()->fetch();

        return $this->response->array($email);
    }

    /**
     * @param $clientID
     * @param CreateClientAPIRequest|CreateTelephoneAPIRequest $request
     * @return Response
     * @SWG\Post(
     *      path="/clients/{clientID}/emails",
     *      summary="Store a newly created Client Email in storage",
     *      tags={"Client Emails"},
     *      description="Store Email from Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Email that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Email")
     *      ),
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
     *                  property="data",
     *                  ref="#/definitions/Email"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store($clientID, Request $request)
    {
        $input = $request->all();

        /** @var Email $email */
        $email = $this->getModel($clientID)->create($input);

        return $this->response->array($email->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @return Response
     * @SWG\Get(
     *      path="/clients/{clientID}/emails/{emailID}",
     *      summary="Display the specified Email from Client",
     *      tags={"Client Emails"},
     *      description="Get Client Email",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *          name="emailID",
     *          description="id of Email",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
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
     *                  property="data",
     *                  ref="#/definitions/Client"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($clientID, $id)
    {
        /** @var Email $email */
        $email = $this->getModel($clientID)->pimp()->findOrFail($id);

        return $this->response->array($email->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @param UpdateClientAPIRequest $request
     * @return Response
     * @SWG\Put(
     *      path="/clients/{clientID}/emails/{emailID}",
     *      summary="Update the specified Client Email in storage",
     *      tags={"Client Emails"},
     *      description="Update Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *          name="emailID",
     *          description="id of Email",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Email that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Email")
     *      ),
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
     *                  property="data",
     *                  ref="#/definitions/Email"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($clientID, $id, UpdateTelephoneAPIRequest $request)
    {
        $input = $request->all();

        /** @var Email $email */
        $email = $this->getModel($clientID)->findOrFail($id);

        $email->update($input);

        return $this->response->array($email->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @return Response
     * @SWG\Delete(
     *      path="/clients/{clientID}/emails/{emailID}",
     *      summary="Remove the specified Email from Client from storage",
     *      tags={"Client Emails"},
     *      description="Delete Email from Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="emailID",
     *          description="id of Email",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
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
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($clientID, $id)
    {
        /** @var Email $email */
        $email = $this->getModel($clientID)->findOrFail($id);

        $email->delete();

        return $this->response->array($email->toArray());
    }

    /**
     * @param $clientID
     * @param $telephoneID
     * @return Response
     * @SWG\Put(
     *      path="/clients/{clientID}/emails/{emailID}/primary",
     *      summary="Set Client Email as Primary",
     *      tags={"Client Emails"},
     *      description="Set Client Email as Primary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *          name="emailID",
     *          description="id of Email",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
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
     *                  property="data",
     *                  ref="#/definitions/Email"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function makePrimary($clientID,$telephoneID)
    {
        /** @var Email $email **/
        $email = $this->getModel($clientID)->findOrFail($telephoneID);
        return $email->makePrimary()->toArray();
    }

    /**
     * @param $clientID
     * @return Response
     * @SWG\Get(
     *      path="/clients/{clientID}/emails/primary",
     *      summary="Set Client Email as Primary",
     *      tags={"Client Emails"},
     *      description="Set Client Email as Primary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
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
     *                  property="data",
     *                  ref="#/definitions/Email"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function getPrimary($clientID)
    {
        /** @var Client $client **/
        $email = $this->getModelOriginal()->findOrFail($clientID)->primaryTelephone;
        return ($email) ? $email->toArray() : $this->response->errorNotFound();
    }

    /**
     * @return mixed
     */
    protected function getModel($clientID)
    {
        return $this->getModelOriginal()->findOrFail($clientID)->emails();
    }

    /**
     * @return mixed
     */
    protected function getModelOriginal()
    {
        return $this->user->clients();
    }
}
