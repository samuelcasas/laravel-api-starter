<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateItemAPIRequest;
use App\Http\Requests\API\UpdateItemAPIRequest;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class ItemController
 * @package App\Http\Controllers\API
 */

class ItemAPIController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/items",
     *      summary="Get a listing of the Items.",
     *      tags={"Item"},
     *      description="Get all Items",
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
     *                  @SWG\Items(ref="#/definitions/Item")
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
        $items = $this->getModel()->pimp()->paginate();

        return $this->response->array($items);
    }

    /**
     * @param CreateItemAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/items",
     *      summary="Store a newly created Item in storage",
     *      tags={"Item"},
     *      description="Store Item",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Item that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Item")
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
     *                  ref="#/definitions/Item"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateItemAPIRequest $request)
    {
        $input = $request->all();

        $item = $this->getModel()->create($input);

        return $this->response->array($item->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/items/{id}",
     *      summary="Display the specified Item",
     *      tags={"Item"},
     *      description="Get Item",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Item",
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
     *                  ref="#/definitions/Item"
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
        /** @var Item $item */
        $item = $this->getModel()->pimp()->findOrFail($id);

        return $this->response->array($item->toArray());
    }

    /**
     * @param int $id
     * @param UpdateItemAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/items/{id}",
     *      summary="Update the specified Item in storage",
     *      tags={"Item"},
     *      description="Update Item",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Item",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Item that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Item")
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
     *                  ref="#/definitions/Item"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateItemAPIRequest $request)
    {
        $input = $request->all();

        /** @var Item $item */
        $item = $this->getModel()->findOrFail($id);

        $item->update($input);

        return $this->response->array($item->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/items/{id}",
     *      summary="Remove the specified Item from storage",
     *      tags={"Item"},
     *      description="Delete Item",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Item",
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
        /** @var Item $item */
        $item = $this->getModel()->findOrFail($id);

        $item->delete();

        return $this->response->array($item->toArray());
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->user->items();
    }
}
