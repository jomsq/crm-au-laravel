<?php
namespace App\Services;

use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class CustomerService
{
    public function getAllCustomers()
    {
        return Customer::all();
    }

    public function getCustomerById($customerId)
    {
        try {
            return Customer::findOrFail($customerId);
        } catch (ModelNotFoundException $e) {
            throw new \Exception("Customer not found", 404);
        }
    }

    public function createCustomer($data)
    {
        try {
            return Customer::create($data);
        } catch (\Exception $e) {
            throw new \Exception("Failed to create customer", 500);
        }
    }

    public function updateCustomer($customerId, $data)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $customer->update($data);
            return $customer;
        } catch (ModelNotFoundException $e) {
            throw new \Exception("Customer not found", 404);
        } catch (\Exception $e) {
            throw new \Exception("Failed to update customer", 500);
        }
    }

    public function deleteCustomer($customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);
            $customer->delete();
        } catch (ModelNotFoundException $e) {
            throw new \Exception("Customer not found", 404);
        } catch (\Exception $e) {
            throw new \Exception("Failed to delete customer", 500);
        }
    }
}