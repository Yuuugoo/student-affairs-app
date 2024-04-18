<?php

namespace App\Livewire;

use App\Models\Accreditation;
use Livewire\Component;

class RequestAct extends Component
{   
    protected static ?string $model = Accreditation::class;
    public function render()
    {
        $user = auth()->user();

        if ($user) {
            $orgName = $user->accreditation->org_name ?? '';
        } else {
            $orgName = null;        
        }

        return view('livewire.request-act', compact('orgName'));
    }

}
