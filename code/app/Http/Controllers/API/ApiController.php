<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    //Get All Customers
    public function fetchCustomers()
    {
        try {
            $customers = $this->customerService->getAllCustomers();

            return response()->json([
                'success' => true,
                'data' => $customers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    //Show Customer information by ID
    public function showCustomer($id)
    {
        try {
            $customer = $this->customerService->getCustomerById($id);

            return response()->json([
                'success' => true,
                'data' => $customer,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    public function addCustomer(Request $request)
    {
        try {
            $data = $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|email|unique:customers,email',
                'contact_number' => 'required|string',
            ]);

            $customer = $this->customerService->createCustomer($data);

            return response()->json([
                'success' => true,
                'data' => $customer,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    //Update Customer Information
    public function updateCustomer(Request $request, $id)
    {
        try {
            $data = $request->validate([
                'first_name' => 'sometimes|string',
                'last_name' => 'sometimes|string',
                'email' => 'sometimes|email|unique:customers,email,' . $id,
                'contact_number' => 'sometimes|string',
            ]);

            $customer = $this->customerService->updateCustomer($id, $data);

            return response()->json([
                'success' => true,
                'data' => $customer,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }

    //Delete Customer Information
    public function deleteCustomer($id)
    {
        try {
            $this->customerService->deleteCustomer($id);

            return response()->json([
                'success' => true,
                'message' => 'Customer deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode());
        }
    }


}
