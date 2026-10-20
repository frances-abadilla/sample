<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;

use App\Http\Requests\API\CreateStoreRequest;
use App\Http\Requests\API\UpdateStoreRequest;

use App\Http\Resources\API\StoreResource;

use App\Repositories\StoreRepository;

class StoreController extends BaseController
{
    protected $store = null;

    public function __construct(StoreRepository $store)
    {
        $this->store = $store;
    }

    public function index()
    {
        try{
            return $this->sendResponse(StoreResource::collection($this->store->getAllStores()), 'Stores retrieved.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try{
            if(! $store = $this->store->getStore($id))
                return $this->sendError('Store not found.');

            return $this->sendResponse(new StoreResource($store), 'Store retrieved.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function store(CreateStoreRequest $request)
    {
        try{
            $store = $this->store->createStore($request->validated());

            return $this->sendResponse(new StoreResource($store), 'Store created.', 201);
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function update(UpdateStoreRequest $request, $id)
    {
        try{
            if(! $store = $this->store->updateStore($id, $request->validated()))
                return $this->sendError('Store not found.');

            return $this->sendResponse(new StoreResource($store), 'Store updated.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try{
            if(! $this->store->deleteStore($id))
                return $this->sendError('Store not found.');

            return $this->sendResponse(null, 'Store deleted.');
        }catch(\Exception $e){
            return $this->sendError('Something went wrong.', ['error' => $e->getMessage()], 500);
        }
    }
}
