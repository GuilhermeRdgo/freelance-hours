<div class="">
    @foreach ($this->projects as $project)
        <a href="{{ route('projects.show', $project) }}">
            {{  $project->id }} . {{ $project->title }}
        </a>
    @endforeach
</div>
