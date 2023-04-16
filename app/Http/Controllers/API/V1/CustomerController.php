<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Resources\V1\CustomerCollection;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomerFilter();
        $filterItems = $filter->transform($request); //[['column','operator','value']]

        $includeInvoices = $request->query('includeInvoices');

        // ?column[operator]=value
        $customer = Customer::where($filterItems);

        if($includeInvoices){
            $customer = $customer->with('invoices');
        }

        return new CustomerCollection($customer->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = new Customer();

        $customer->name = $request->input('name');
        $customer->type = $request->input('type');
        $customer->email = $request->input('email');
        $customer->address = $request->input('address');
        $customer->city = $request->input('city');
        $customer->state = $request->input('state');
        $customer->postal_code = $request->input('postal_code');

        $customer->save();

        return response()->json([
            'message' => 'Successfully submitted',
            'value' => 'succeed'
        ]);

        // The following code will just return all the given data back if data is inserted.
        // return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');
        if($includeInvoices){
            return new CustomerResource($customer->loadMissing('invoices'));
        }

        // http://location/api/v1/customers/1 returns only data where id=1
    
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());

        return response()->json([
            'message' => 'Successfully updated',
            'value' => 'updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
