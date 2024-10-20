<?php

namespace App\Livewire\Proposals;

use App\Actions\ArrangePositions;
use App\Models\Project;
use App\Models\Proposal;
use App\Notifications\LostPosition;
use App\Notifications\NewProposal;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Create extends Component
{   
    public Project $project;
    public bool $modal = false;

    #[Rule(['required', 'numeric', 'min:1'])]
    public int $hours = 0;

    #[Rule(['required', 'email'])]
    public string $email = '';

    #[Rule(['required', 'accepted'])]
    public bool $agree = false;	

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            $proposal = $this->project->proposals()->updateOrCreate(
                ['email' => $this->email],
                ['hours' => $this->hours]
            );

            $this->arrangePositions($proposal);
        });

        $this->dispatch('proposal::created');

        $this->project->author->notify(new NewProposal($this->project));
        
        $this->modal = false;
    }

    public function arrangePositions(Proposal $proposal)
    {
        $query = DB::select('
            select *, row_number() over (order by hours asc) as newPosition
            from proposals
            where project_id = :project
            ', ['project' => $proposal->project_id]);
        $position = collect($query)->where('id', '=', $proposal->id)->first();
        $otherProposal = collect($query)->where('position', '=', $position->newPosition)->first();
        if ($otherProposal) {
            $proposal->update(['position_status' => 'up']);
            $oProposal = Proposal::find($otherProposal->id);
            
            $oProposal->update(['position_status' => 'down']);
            $oProposal->notify(new LostPosition($this->project));
        }
        ArrangePositions::run($proposal->project_id);
    }

    public function render()
    {
        return view('livewire.proposals.create');
    }
}
