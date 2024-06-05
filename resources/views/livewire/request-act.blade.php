<style>
  .btn {
    background-color: #007bff;
    color: white;
    padding: 50px 50px;
    border-radius: 0.25rem;
  }

  .btn-primary {
    --tw-bg-opacity: 1;
    background-color: #cbb26a;
    border-color: #cbb26a;
    color: white;
  }

  .btn:hover {
    --tw-bg-opacity: 0.9;
    background-color: #cbb26a;
    border-color: #cbb26a;
    color: white;
  }

  .org-name {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 1rem;
  }

  .off-campus,
  .in-campus {
    margin-bottom: 1rem;
  }

  .activity-for {
    font-size: 0.9rem;
    font-weight: bold;
  }

  .register-for-box {
    border: 1px solid #cccdce;
    border-radius: 10px;
    padding: 1rem;
  }

  .text-xl {
    padding: 1rem;
  }

  .text-green {
    color: green;
  }

  .text-red {
    color: red;
  }

  .btn.disabled {
    background-color: #cccccc;
    border-color: #cccccc;
    
  }
</style>

<div class="grid grid-cols-2 gap-4">
    <div class="col-span-2">
        <p class="org-name">{{ $orgName }}</p>
    </div>
    <div class="col-span-2 register-for-box">
        <h1 class="text-xl font-bold">
            Accreditation Status: 
            @if ($accreditationStatus === 'ACCREDITED')
                <span class="text-green">{{ $accreditationStatus }}</span>
            @else
                <span class="text-red">{{ $accreditationStatus }}</span>
            @endif
        </h1>
        <span class="activity-for"></span>
        <button 
            id="offCampusButton" 
            type="button" 
            class="btn btn-primary {{ $accreditationStatus !== 'ACCREDITED' ? 'disabled' : '' }}"
            {{ $accreditationStatus !== 'ACCREDITED' ? 'disabled' : '' }}
        >
            Activity for Off-Campus
        </button>
        <button 
            id="inCampusButton" 
            type="button" 
            class="btn btn-primary {{ $accreditationStatus !== 'ACCREDITED' ? 'disabled' : '' }}"
            {{ $accreditationStatus !== 'ACCREDITED' ? 'disabled' : '' }}
        >
            Activity for In-Campus
        </button>
    </div>
</div>

<script>
    document.getElementById('offCampusButton').addEventListener('click', function() {
        if (!this.disabled) {
            window.location.href = '/studentOfficer/request-act-offs/index';
        }
    });

    document.getElementById('inCampusButton').addEventListener('click', function() {
        if (!this.disabled) {
            window.location.href = '/studentOfficer/request-acts/index';
        }
    });

    fetch('/studentOfficer/accreditations/index')
        .then(response => response.json())
        .then(data => {
            const accreditationStatus = data.status;

            if (accreditationStatus === 'rejected') {
                document.getElementById('offCampusButton').disabled = true;
                document.getElementById('inCampusButton').disabled = true;
            }
        });
</script>
