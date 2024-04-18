<x-filament-panels::page>

<script>

function showEventDetails(event) {
    // Access details object from the event data
    const details = event.extendedProps.details;
  
    // Create the pop-up content (HTML structure)
    const popUpContent = `
      <h2>${details.title}</h2>
      <p><b>Organization:</b> ${details.org_name}</p>
      <p><b>Venue:</b> ${details.venue}</p>
      <p>${details.description}</p>
    `;
  
    // Create a pop-up element dynamically (optional)
    const popUp = document.createElement('div');
    popUp.classList.add('event-details-popup'); // Add a CSS class for styling
    popUp.innerHTML = popUpContent;
  
    // Alternatively, use an existing element with appropriate ID
    // const popUp = document.getElementById('event-details-popup');
    // popUp.innerHTML = popUpContent;
  
    // Display the pop-up (adjust positioning based on your needs)
    popUp.style.display = 'block';
    document.body.appendChild(popUp); // Append to body for visibility
  
    // Add a close button or functionality to close the pop-up (optional)
    // ...
    document.addEventListener('DOMContentLoaded', function() {
  let calendar = FullCalendar.getInstance('#calendar'); // Assuming your calendar has this ID
  calendar.getEventClickApi().click = showEventDetails; // Set the event click handler
    });

  }
</script>

    <div>
        @livewire(\App\Livewire\CalendarWidget::class)
    </div>
</x-filament-panels::page>
