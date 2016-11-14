<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTelephoneAPIRequest;
use App\Http\Requests\API\UpdateTelephoneAPIRequest;
use App\Models\Telephone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class ClientTelephonesAPIController
 * @package App\Http\Controllers\API
 */

class ClientTelephonesAPIController extends Controller
{
    use Helpers;

    /**
     * @param $clientID
     * @param Request $req
     * @return Response
     * @internal param Request $request
     * @SWG\Get(
     *      path="/clients/{clientID}/telephones",
     *      summary="Get a listing of the Clients.",
     *      tags={"Client Telephones"},
     *      description="Get all Client Telephones",
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
     *                  @SWG\Items(ref="#/definitions/Telephone")
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
        $telephone = $this->getModel($clientID)->pimp()->fetch();

        return $this->response->array($telephone);
    }

    /**
     * @param $clientID
     * @param CreateClientAPIRequest|CreateTelephoneAPIRequest $request
     * @return Response
     * @SWG\Post(
     *      path="/clients/{clientID}/telephones",
     *      summary="Store a newly created Client Telephone in storage",
     *      tags={"Client Telephones"},
     *      description="Store Telephone from Client",
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
     *          description="Telephone that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Telephone")
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
     *                  ref="#/definitions/Telephone"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store($clientID, CreateTelephoneAPIRequest $request)
    {
        $input = $request->all();

        /** @var Telephone $telephone */
        $telephone = $this->getModel($clientID)->create($input);

        if($this->getModelOriginal()->findOrFail($clientID)->telephones()->count() == 1) {
            $telephone->makePrimary();
            $telephone = $telephone->fresh();
        }

        return $this->response->array($telephone->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @return Response
     * @SWG\Get(
     *      path="/clients/{clientID}/telephones/{telephoneID}",
     *      summary="Display the specified Telephone from Client",
     *      tags={"Client Telephones"},
     *      description="Get Client Telephone",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *          name="telephoneID",
     *          description="id of Telephone",
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
        /** @var Telephone $telephone */
        $telephone = $this->getModel($clientID)->pimp()->findOrFail($id);

        return $this->response->array($telephone->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @param UpdateClientAPIRequest $request
     * @return Response
     * @SWG\Put(
     *      path="/clients/{clientID}/telephones/{telephoneID}",
     *      summary="Update the specified Client telephone in storage",
     *      tags={"Client Telephones"},
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
     *          name="telephoneID",
     *          description="id of Telephone",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Telephone that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Telephone")
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
     *                  ref="#/definitions/Telephone"
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

        /** @var Telephone $telephone */
        $telephone = $this->getModel($clientID)->findOrFail($id);

        $telephone->update($input);

        return $this->response->array($telephone->toArray());
    }

    /**
     * @param $clientID
     * @param int $id
     * @return Response
     * @SWG\Delete(
     *      path="/clients/{clientID}/telephones/{telephoneID}",
     *      summary="Remove the specified Telephone from Client from storage",
     *      tags={"Client Telephones"},
     *      description="Delete Telephone from Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="telephoneID",
     *          description="id of Telephone",
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
        /** @var Telephone $telephone */
        $telephone = $this->getModel($clientID)->findOrFail($id);

        $telephone->delete();

        return $this->response->array($telephone->toArray());
    }

    /**
     * @param $clientID
     * @param $telephoneID
     * @return Response
     * @SWG\Put(
     *      path="/clients/{clientID}/telephones/{telephoneID}/primary",
     *      summary="Set Client Telephone as Primary",
     *      tags={"Client Telephones"},
     *      description="Set Client Telephone as Primary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="clientID",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *     @SWG\Parameter(
     *          name="telephoneID",
     *          description="id of Telephone",
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
     *                  ref="#/definitions/Telephone"
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
        /** @var Telephone $telephone **/
        $telephone = $this->getModel($clientID)->findOrFail($telephoneID);
        return $telephone->makePrimary()->toArray();
    }

    /**
     * @param $clientID
     * @return Response
     * @SWG\Get(
     *      path="/clients/{clientID}/telephones/primary",
     *      summary="Set Client Telephone as Primary",
     *      tags={"Client Telephones"},
     *      description="Set Client Telephone as Primary",
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
     *                  ref="#/definitions/Telephone"
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
        $telephone = $this->getModelOriginal()->findOrFail($clientID)->primaryTelephone;
        return ($telephone) ? $telephone->toArray() : $this->response->errorNotFound();
    }

    /**
     * @return mixed
     */
    protected function getModel($clientID)
    {
        return $this->getModelOriginal()->findOrFail($clientID)->telephones();
    }

    /**
     * @return mixed
     */
    protected function getModelOriginal()
    {
        return $this->user->clients();
    }
}
