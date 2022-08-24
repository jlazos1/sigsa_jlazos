<?php

namespace App\Http\Livewire;

use App\Models\Provider;
use Livewire\Component;

class FormProviderComponent extends Component
{
    public $rut, $name, $address, $city, $email;

    public function render()
    {
        return view('livewire.form-provider-component');
    }

    public function store()
    {
        $provider = new Provider();
        $provider->rut = $this->rut;
        $provider->name = $this->name;
        $provider->address = $this->address;
        $provider->city = $this->city;
        $provider->email = $this->email;
        $provider->save();
    }
}
