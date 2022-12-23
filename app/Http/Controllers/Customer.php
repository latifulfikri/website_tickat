<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer as CustomerModel;

class Customer extends Controller
{
    public function index()
    {
        $customers = CustomerModel::all();
       return view('dashboard.customer.index', ['customers' => $customers]);
    }

    public function create()
    {
        return view('dashboard.customer.add');
    }

    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'email' => 'required',
        'phone' => 'required',
        'gender' => 'required',
        'password' => 'required',
        'password-confirm' => 'required|same:password',
    ]);

    $datas = [
        'CustomerName' => $request->name,
        'CustomerEmail' => $request->email,
        'CustomerPhone' => $request->phone,
        'CustomerGender' => $request->gender,
        'CustomerPass' => $request->password,
        ];

    CustomerModel::create($datas);

    return redirect('/dashboard/customer')->with('status', $request->name.' has been added!');

    }

    public function show($id)
    {
        $customers = CustomerModel::find($id);
        return view('dashboard.customer.show', ['customers' => $customers]);
    }

    public function edit($id)
    {
        $customers = CustomerModel::find($id);
        return view('dashboard.customer.edit',['customers' => $customers]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'password' => 'required',
            'password-confirm' => 'required|same:password',
        ]);
    
        $datas = CustomerModel::find($id);

            $datas->CustomerName = $request->name;
            $datas->CustomerEmail = $request->email;
            $datas->CustomerPhone = $request->phone;
            $datas->CustomerGender = $request->gender;

            $datas->save();
    
        return redirect('/dashboard/customer')->with('status', $request->name.' has been update!');
    
        }

    public function destroy($id)
    {
        $customers = CustomerModel::find($id);
        CustomerModel::destroy($id);
        
        return redirect('/dashboard/customer')->with('status', $customers->name.' has been deleted!');
    }
}
