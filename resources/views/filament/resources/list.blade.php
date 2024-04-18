<!-- @extends('filament::layouts.app')

@section('content')
    <div class="mt-8 space-y-4">
        @foreach ($records as $record)
            <div class="flex items-center space-x-2">
                <a href="{{ route('resource.show', ['resource' => 'requests-accred', 'record' => $record->id]) }}" class="btn btn-primary">View {{ $record->name }}</a>
                <a href="{{ route('resource.edit', ['resource' => 'requests-accred', 'record' => $record->id]) }}" class="btn btn-secondary">Edit {{ $record->name }}</a>
            </div>
        @endforeach
    </div>
@endsection -->
