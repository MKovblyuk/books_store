<?php

namespace App\Http\Controllers\Api\V1\Addresses;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Addresses\StoreAddressRequest;
use App\Http\Requests\V1\Addresses\UpdateAddressRequest;
use App\Http\Resources\V1\Addresses\AddressCollection;
use App\Http\Resources\V1\Addresses\AddressResource;
use App\Models\V1\Addresses\Address;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $addresses = QueryBuilder::for(Address::class)
            ->allowedFields('id', 'settlement_name', 'street_name', 'street_number', 'postal_code', 'district_id')
            ->allowedFilters(AllowedFilter::exact('id'), 'settlement_name', 'street_name', AllowedFilter::exact('district_id'))
            ->allowedSorts('id', 'settlement_name', 'street_name', 'street_number', 'postal_code', 'district_id')
            ->allowedIncludes('district')
            ->get();

        return new AddressCollection($addresses);
    }

    public function store(StoreAddressRequest $request)
    {
        $this->authorize('create', Address::class);        
        Address::create($request->validated());

        return response()->json(['message' => 'Address successfully created'], 201);
    }

    public function show(Address $address)
    {
        return new AddressResource($address);
    }

    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorize('update', $address);
        $address->update($request->validated());

        return response()->json(['message' => 'Address successfully updated'], 200);
    }

    public function destroy(Address $address)
    {
        $this->authorize('delete', $address);

        return $address->delete()
            ? response()->noContent()
            : response()->json(['message' => 'Address not deleted'], 400);
    }
}
