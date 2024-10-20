<x-layouts.app title="FreelanceHours | {{ __('Project') }} - {{ $project->title }}">
    <div class="grid grid-cols-3 gap-6">
        @livewire('projects.show', ['project' => $project])
        @livewire('projects.proposals', ['project' => $project])
    </div>
</x-layouts.app>