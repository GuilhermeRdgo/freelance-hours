<div>
    Show {{ $project->title }}


    @livewire('projects.show', ['project' => $project])
    @livewire('projects.proposals', ['project' => $project])
</div>
