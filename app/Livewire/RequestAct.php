<?php

namespace App\Livewire;

use App\Models\Accreditation;
use Livewire\Component;
use App\Enums\Status;
use Illuminate\Support\Facades\Log;

class RequestAct extends Component
{
    protected static ?string $model = Accreditation::class;

    public function render()
    {
        $user = auth()->user();
        $orgName = $user->accreditation->org_name ?? '';
        $status = $user->accreditation->status ?? null;

        if ($status instanceof Status) {
            $statusValue = $status->value;
        } else {
            $statusValue = $status;
        }

        $accreditationStatus = $this->getAccreditationStatus($statusValue);

        return view('livewire.request-act', compact('orgName', 'accreditationStatus'));
    }

    private function getAccreditationStatus($status)
    {
        if ($status === Status::REJECTED->value || $status === Status::PENDING->value) {
            return 'NOT ACCREDITED';
        } elseif ($status === Status::APPROVED->value) {
            return 'ACCREDITED';
        } else {
            return 'NOT ACCREDITED';
        }
    }
}




