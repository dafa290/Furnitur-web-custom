<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    protected function currentUser(Request $request): ?User
    {
        return $request->session()->has('user_id') ? User::find($request->session()->get('user_id')) : null;
    }

    public function add(Request $request)
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return redirect('/login');
        }

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'address_line' => 'required|string|max:512',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        if (! empty($data['is_default'])) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        $user->addresses()->create($data);

        return redirect('/alamat/manage');
    }

    public function edit(Request $request, int $id)
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return redirect('/login');
        }

        $address = Address::where('id', $id)->where('user_id', $user->id)->first();
        if (! $address) {
            return redirect('/alamat/manage');
        }

        return view('pages.addresses', [
            'user' => $user,
            'address' => $address,
            'cartCount' => $user->cartItems()->sum('quantity'),
        ]);
    }

    public function update(Request $request, int $id)
    {
        $user = $this->currentUser($request);
        if (! $user) {
            return redirect('/login');
        }

        $address = Address::where('id', $id)->where('user_id', $user->id)->first();
        if (! $address) {
            return redirect('/alamat/manage');
        }

        $data = $request->validate([
            'label' => 'required|string|max:255',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:32',
            'address_line' => 'required|string|max:512',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        if (! empty($data['is_default'])) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
        }

        $address->update($data);
        return redirect('/alamat/manage');
    }

    public function delete(Request $request, int $id)
    {
        $user = $this->currentUser($request);
        if ($user) {
            Address::where('id', $id)->where('user_id', $user->id)->delete();
        }
        return redirect('/alamat/manage');
    }

    public function setDefault(Request $request, int $id)
    {
        $user = $this->currentUser($request);
        if ($user) {
            Address::where('user_id', $user->id)->update(['is_default' => false]);
            Address::where('id', $id)->where('user_id', $user->id)->update(['is_default' => true]);
        }
        return redirect('/alamat/manage');
    }
}
