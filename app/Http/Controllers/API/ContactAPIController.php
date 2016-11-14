<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateContactAPIRequest;
use App\Http\Requests\API\UpdateContactAPIRequest;
use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class ContactController
 * @package App\Http\Controllers\API
 */

class ContactAPIController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/contacts",
     *      summary="Get a listing of the Contacts.",
     *      tags={"Contact"},
     *      description="Get all Contacts",
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
     *                  @SWG\Items(ref="#/definitions/Contact")
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
        $contacts = $this->getModel()->pimp()->fetch();

        return $this->response->array($contacts);
    }

    /**
     * @param CreateContactAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/contacts",
     *      summary="Store a newly created Contact in storage",
     *      tags={"Contact"},
     *      description="Store Contact",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contact that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contact")
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
     *                  ref="#/definitions/Contact"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateContactAPIRequest $request)
    {
        $input = $request->all();

        $contact = $this->getModel()->create($input);

        return $this->response->array($contact->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/contacts/{id}",
     *      summary="Display the specified Contact",
     *      tags={"Contact"},
     *      description="Get Contact",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contact",
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
     *                  ref="#/definitions/Contact"
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
        /** @var Contact $contact */
        $contact = $this->getModel()->pimp()->findOrFail($id);

        return $this->response->array($contact->toArray());
    }

    /**
     * @param int $id
     * @param UpdateContactAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/contacts/{id}",
     *      summary="Update the specified Contact in storage",
     *      tags={"Contact"},
     *      description="Update Contact",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contact",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contact that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contact")
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
     *                  ref="#/definitions/Contact"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateContactAPIRequest $request)
    {
        $input = $request->all();

        /** @var Contact $contact */
        $contact = $this->getModel()->findOrFail($id);

        $contact->update($input);

        return $this->response->array($contact->toArray());
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/contacts/{id}",
     *      summary="Remove the specified Contact from storage",
     *      tags={"Contact"},
     *      description="Delete Contact",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contact",
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
        /** @var Contact $contact */
        $contact = $this->getModel()->findOrFail($id);

        $contact->delete();

        return $this->response->array($contact->toArray());
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->user->contacts();
    }
}
