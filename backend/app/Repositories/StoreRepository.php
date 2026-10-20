<?php

namespace App\Repositories;

use App\Models\Store;

class StoreRepository
{
    public function getAllStores()
    {
        return Store::orderBy('name')->get();
    }

    public function getStore($id)
    {
        return Store::find($id);
    }

    public function createStore(array $data)
    {
        return Store::create($this->fields($data));
    }

    public function updateStore($id, array $data)
    {
        if(! $store = Store::find($id))
            return null;

        $store->update($this->fields($data));

        return $store;
    }

    public function deleteStore($id)
    {
        return (bool) Store::whereKey($id)->delete();
    }

    private function fields(array $data): array
    {
        return [
            'name'    => $data['name'],
            'code'    => $data['code'],
            'address' => $data['address'] ?? '',
            'status'  => $data['status'] ?? 'active',
        ];
    }
}
