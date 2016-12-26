<?php

namespace App\Http\Controllers\API\Clients;

use App\Http\Requests\API\CreateClientAPIRequest;
use App\Http\Requests\API\UpdateClientAPIRequest;
use App\Models\Client;
use Czim\NestedModelUpdater\ModelUpdater;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class ClientController
 * @package App\Http\Controllers\API
 */

class ClientAPIController extends Controller
{
    use Helpers;

    /**
     * @return Response
     *
     * @SWG\Get(
     *      path="/clients",
     *      summary="Get a listing of the Clients.",
     *      tags={"Client"},
     *      description="Get all Clients",
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
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Client")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index()
    {
        $clients = $this->getModel()->pimp()->fetch();

        return $this->response->array($clients);
    }

    /**
     * @param CreateClientAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/clients",
     *      summary="Store a newly created Client in storage",
     *      tags={"Client"},
     *      description="Store Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Client that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Client")
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
    public function store(CreateClientAPIRequest $request)
    {
        $input = $request->all();

        $client = $this->create($input);

        return $this->response->array($client->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/clients/{id}",
     *      summary="Display the specified Client",
     *      tags={"Client"},
     *      description="Get Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
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
    public function show($id)
    {
        /** @var Client $client */
        $client = $this->getModel()->pimp()->fetchSingle($id);

        return $this->response->array($client->toArray());
    }

    /**
     * @param int $id
     * @param UpdateClientAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/clients/{id}",
     *      summary="Update the specified Client in storage",
     *      tags={"Client"},
     *      description="Update Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Client",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Client that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Client")
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
    public function update($id, UpdateClientAPIRequest $request)
    {
        $input = $request->all();

        /** @var Client $client */
        $client = $this->getModel()->findOrFail($id);

        $client->update($input);

        return $this->response->array($client->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/clients/{id}",
     *      summary="Remove the specified Client from storage",
     *      tags={"Client"},
     *      description="Delete Client",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
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
    public function destroy($id)
    {
        /** @var Client $client */
        $client = $this->getModel()->findOrFail($id);

        $client->delete();

        return $this->response->array($client->toArray());
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->user->clients();
    }

    protected function create($input)
    {
        $updater = new ModelUpdater(Client::class);

        return $updater->setUnguardedAttribute('user_id', $this->user->id)
            ->create($input)
            ->model();
    }

    public function validatePrefix($prefix)
    {
        $count = $this->getModel()->where('prefix', $prefix)->count();

        return $count;
    }
}
