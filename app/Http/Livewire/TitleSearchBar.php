<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Archive;
use App\Models\Department;

class TitleSearchBar extends Component
{

    public $query;
    public $titles;
    public $currentPage;

    public function mount($currentPage) {

        $this->currentPage = $currentPage;

        $this->resetSearch();
    }

    public function resetSearch() {
        $this->query = "";
        $this->titles = [];
    }

    public function updatedQuery() {

        if($this->currentPage == 'projects') {
            $this->titles = Archive::where('archive_status', 1)->where('title', 'LIKE', '%' . $this->query . '%')->orderBy('created_at', 'desc')->limit(5)->get()->toArray(); 
        } elseif($this->currentPage == 'bookmarks') {
            $this->titles = Archive::whereHasBookmark(
                auth()->user()
            )->where('title', 'LIKE', '%' . $this->query . '%')->orderBy('created_at', 'desc')->limit(5)->get()->toArray(); 
        }
        else {
            $deptData = Department::all()->where('dept_name', strtoupper($this->currentPage))->first();
    
            $this->titles = Archive::where('department_id', $deptData->id)->where('archive_status', 1)->where('title', 'LIKE', '%' . $this->query . '%')->orderBy('created_at', 'desc')->limit(5)->get()->toArray(); 
        }

    }


    public function render()
    {
        return view('livewire.title-search-bar');
    }
}
