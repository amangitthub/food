<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $usersTable = (new User())->getTable();

        $query = User::query();

        // Admin accounts ko customer list mein mat dikhao.
        if (Schema::hasColumn($usersTable, 'role')) {
            $query->where($usersTable . '.role', 'user');
        }

        // Customer search.
        if ($search !== '') {
            $query->where(function ($q) use ($search, $usersTable) {
                $q->where($usersTable . '.name', 'like', "%{$search}%")
                    ->orWhere($usersTable . '.email', 'like', "%{$search}%");

                if (Schema::hasColumn($usersTable, 'phone')) {
                    $q->orWhere($usersTable . '.phone', 'like', "%{$search}%");
                }
            });
        }

        $customers = $query->latest()
            ->paginate(15)
            ->withQueryString();

        $customerIds = $customers->getCollection()
            ->pluck('id')
            ->all();

        // Saved addresses: default address ko priority do.
        $addresses = collect();

        if (!empty($customerIds) && Schema::hasTable('addresses')) {
            $addresses = DB::table('addresses')
                ->whereIn('user_id', $customerIds)
                ->orderByRaw(
                    "CASE WHEN is_default = 'Yes' THEN 0 ELSE 1 END"
                )
                ->orderByDesc('id')
                ->get()
                ->groupBy('user_id');
        }

        // Har customer ke total orders.
        $orderCounts = collect();

        if (!empty($customerIds) && Schema::hasTable('orders')) {
            $orderCounts = DB::table('orders')
                ->select('user_id', DB::raw('COUNT(*) as total_orders'))
                ->whereIn('user_id', $customerIds)
                ->groupBy('user_id')
                ->pluck('total_orders', 'user_id');
        }

        $customers->getCollection()->transform(
            function ($customer) use ($addresses, $orderCounts) {
                $address = $addresses->get($customer->id)?->first();

                $customer->customer_phone =
                    $customer->phone
                    ?? ($address->mobile ?? 'N/A');

                $customer->customer_city =
                    $address->city ?? 'N/A';

                $customer->total_orders =
                    $orderCounts->get($customer->id, 0);

                $customer->customer_status =
                    $customer->status ?? 'Active';

                return $customer;
            }
        );

        return view('dash.customers', compact('customers', 'search'));
    }
}
