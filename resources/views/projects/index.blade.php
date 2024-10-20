<x-layouts.app title="FreelanceHours | {{ __('Projects') }}">

    
    <a href="{{ route('projects.show', '1') }}">
        Primeiro projeto
    </a>


    @livewire('projects.index') 
</x-layouts.app>
