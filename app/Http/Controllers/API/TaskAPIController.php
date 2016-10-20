<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateTaskAPIRequest;
use App\Http\Requests\API\UpdateTaskAPIRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Dingo\Api\Routing\Helpers;

/**
 * Class TaskController
 * @package App\Http\Controllers\API
 */

class TaskAPIController extends Controller
{
    use Helpers;

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/tasks",
     *      summary="Get a listing of the Tasks.",
     *      tags={"Task"},
     *      description="Get all Tasks",
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
     *                  @SWG\Items(ref="#/definitions/Task")
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
        $tasks = $this->getModel()->pimp()->paginate();

        return $this->response->array($tasks);
    }

    /**
     * @param CreateTaskAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/tasks",
     *      summary="Store a newly created Task in storage",
     *      tags={"Task"},
     *      description="Store Task",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Task that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Task")
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
     *                  ref="#/definitions/Task"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTaskAPIRequest $request)
    {
        $input = $request->all();

        $task = $this->getModel()->create($input);

        return $this->response->array($task);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/tasks/{id}",
     *      summary="Display the specified Task",
     *      tags={"Task"},
     *      description="Get Task",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Task",
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
     *                  ref="#/definitions/Task"
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
        /** @var Task $task */
        $task = $this->getModel()->pimp()->find($id);

        return $this->response->array($task);
    }

    /**
     * @param int $id
     * @param UpdateTaskAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/tasks/{id}",
     *      summary="Update the specified Task in storage",
     *      tags={"Task"},
     *      description="Update Task",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Task",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Task that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Task")
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
     *                  ref="#/definitions/Task"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTaskAPIRequest $request)
    {
        $input = $request->all();

        /** @var Task $task */
        $task = $this->getModel()->find($id);

        $task->update($input);

        return $this->response->array($task);
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/tasks/{id}",
     *      summary="Remove the specified Task from storage",
     *      tags={"Task"},
     *      description="Delete Task",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Task",
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
        /** @var Task $task */
        $task = $this->getModel()->find($id);

        $task->delete();

        return $this->response->array($task);
    }

    /**
     * @return mixed
     */
    protected function getModel()
    {
        return $this->user->tasks();
    }
}
