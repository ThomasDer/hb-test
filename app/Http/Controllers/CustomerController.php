<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatchHasOptinRequest;
use App\Models\Customer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getCustomers()
    {
        return Customer::get();
    }

    public function getCustomersVisits()
    {
        $query = <<< heredoc
SELECT
    c.id,
    c.first_name,
    s.name,
    min(v.created_at) as `First visit`,
    max(v.created_at) as `Last visit`,
    count(v.customer_id) as `Number of visits`
FROM
    visits v
    LEFT JOIN customers c ON v.customer_id = c.id
    LEFT JOIN stores s ON s.id = c.store_id
WHERE
    v.store_id = c.store_id
GROUP BY
    v.customer_id
ORDER BY
    c.id
heredoc;

        $results = DB::select($query);
        return $results;
    }

    public function getCustomer(Request $request, Customer $customer)
    {
        return $customer;
    }

    public function updateHasOptin(PatchHasOptinRequest $request, Customer $customer)
    {
        $customer->update(request()->all());
        $customer->save();

        return $customer;
    }
}
