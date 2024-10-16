<?php

namespace App\Http\Controllers;

use App\Models\EmployeeShift;
use App\Models\Order;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd(User::where('role_id', 2)->withSum('orders', 'due')->get());
        if (!auth()->user()->role->hasPermissionTo('view customer')) {
            return abort(403, 'You do not have permission to access the customer view.');
        }
        $customers = User::withSum('orders', 'due')
            ->when($request->due_customer == 1, function ($query) {
                $query->whereHas('orders', function ($query) {
                    $query->where('due', '>', 0);
                });
            })
            ->latest()
            ->filter()
            ->paginate(24)
            ->withQueryString();

        return view('pages.customers.list', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->role->hasPermissionTo('create customer')) {
            return abort(403, 'You do not have permission to access the customer create.');
        }
        $customers = new User();
        $roles = Role::pluck('name', 'id')->toArray();
        return view('pages.customers.create', compact('customers', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->user()->role->hasPermissionTo('create customer')) {
            return abort(403, 'You do not have permission to access the customer create.');
        }

        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string', 'unique:users,phone'],
            'email' => ['nullable', 'email'],
            'address' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'discount' => ['nullable', 'string'],
            'role' => ['required', 'string'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'role_id' => $request->role,
            'discount' => $request->discount ?? 0,
        ]);
        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }
        return redirect()->route('customers.index')->with('success', 'Customers Added Success!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $customer)
    {
        if (!auth()->user()->role->hasPermissionTo('view customer')) {
            return abort(403, 'You do not have permission to access the customer create.');
        }
        if (request()->form && request()->to) {
            $orders = $customer->orders->whereBetween('created_at', [request()->form, request()->to]);
        } else {
            $orders = $customer->orders;
        }
        // $transactions = Transaction::where('user_id', $customer->id)->latest()->get();
        // dd($customer);
        return view('pages.customers.invoice', compact('customer', 'orders'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $customer)
    {
        if (!auth()->user()->role->hasPermissionTo('edit customer')) {
            return abort(403, 'You do not have permission to access the customer edit.');
        }
        $roles = Role::pluck('name', 'id')->toArray();
        return view('pages.customers.edit', compact('customer', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $customer)
    {
        if (!auth()->user()->role->hasPermissionTo('edit customer')) {
            return abort(403, 'You do not have permission to access the customer edit.');
        }
        $request->validate([
            'name' => ['required', 'string'],
            'phone' => ['nullable', 'string', Rule::unique('users')->ignore($customer->id)],
            'email' => ['nullable', 'string'],
            'address' => ['nullable', 'string'],
            'gender' => ['nullable', 'string'],
            'discount' => ['nullable', 'string'],
            'role' => ['required'],
        ]);
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'discount' => $request->discount,
            'role_id' => $request->role,
        ]);

        if ($request->password) {
            $customer->update([
                'password' => bcrypt($request->password),
            ]);
        }
        return back()->with('success', 'Customer Edit Success!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $customer)
    {
        if (!auth()->user()->role->hasPermissionTo('delete customer')) {
            return abort(403, 'You do not have permission to access the customer delete.');
        }
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer Delete Success!');
    }

    public function deposite_full($customer, Request $request)
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);
        $orders = Order::where('customer_id', $customer)->where('due', '>', 0)->orderBy('due', 'desc')->get();
        if (!$orders) {
            return back()->withErrors('This customer does not have any due orders');
        }
        Transaction::create([
            'user_id' => $customer,
            'amount' => $request->amount,
        ]);
        $amountRemaining = $request->amount;

        foreach ($orders as $order) {
            $due = $order->due;
            if ($amountRemaining >= $order->due) {

                $order->paid = $order->paid + $order->due;
                $order->due = 0;
                $order->status = 'PAID';
                $order->save();
                $amountRemaining -= $due;
            } else {
                if ($amountRemaining > 0) {
                    $order->paid = $order->paid + $amountRemaining;
                    $order->due = $order->due - $amountRemaining;
                    $order->status = 'DUE';
                    $order->save();
                    $amountRemaining = 0;
                }
            }
        }
        return back()->with('success', 'Deposite success!');
    }
    public function dashboardForCustomer()
    {
        $user = auth()->user();
        return view('pages.customers.infoDeleteDashboard', compact('user'));
    }
    public function customerInfoDelete()
    {
        // Get the authenticated user
        $user = Auth::user();

        // Set email and phone to null
        $user->email = null;
        $user->phone = null;
        $user->save();

        // Revoke all of the user's tokens
        $user->tokens()->delete();

        // Optionally, you can logout the user
        Auth::logout();

        // Redirect the user to a confirmation page or wherever you need
        return redirect()->route('login')->with('success', 'Your account has been deleted successfully. You have been logged out from all devices.');
    }

    public function customerDelete()
    {
        return view('pages.customers.infoDeleteCustomer');
    }

    public function customerShifts(Request $request, User $customer)
    {
        // show data on frontend
        $shifts = EmployeeShift::where('user_id', $customer->id);
        if (!$request->from || !$request->to) {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();

            $shifts = $shifts->whereDate('clock_in', '>=', $startOfMonth)
                ->whereDate('clock_in', '<=', $endOfMonth);
        } else {
            if ($request->from) {
                $shifts = $shifts->whereDate('clock_in', '>=', $request->from);
            }
            if ($request->to) {
                $shifts = $shifts->whereDate('clock_in', '<=', $request->to);
            }
        }
        $shifts = $shifts->get();
        return view('pages.customers.shifts', compact('shifts', 'customer'));
    }
}
