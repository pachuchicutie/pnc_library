<?php

namespace App\Http\Livewire;

use App\Models\Admin;
use Livewire\Component;
use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CurriculumList extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $search = '';

    public $sortField = 'id';

    public $sortDirection = 'asc';

    public $curriculumTitle;

    public $deleteCurriculum;

    public $viewCurriculum;

    // Viewing User Info
    public $curriculumId;
    public $departmentId;
    public $curr_name;
    public $curr_description;
    public $curr_status;

    // Modals
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showViewModal = false;

    // Editing Table
    public Curriculum $editing;

    protected $rules = [
        'editing.department_id' => 'required',
        'editing.curr_name' => 'required',
        'editing.curr_description' => 'required',
        'editing.curr_status' => 'required',
    ];

    public function mount() {
        $this->editing = $this->makeBlankCurriculum();
    }

    public function closeModal() {

        $this->showEditModal = false;

    }

    public function create() {

        $this->resetErrorBag();

        if ($this->editing->getKey()) $this->editing = $this->makeBlankCurriculum();

        $this->showEditModal = true;

        $this->curriculumTitle = "Add Curriculum";
    }

    public function view($curriculum) {
        $this->viewCurriculum = Curriculum::find($curriculum);

        $this->curriculumId = $this->viewCurriculum->id;

        $this->departmentId = $this->viewCurriculum->department_id;

        $this->curr_name = $this->viewCurriculum->curr_name;

        $this->curr_description = $this->viewCurriculum->curr_description;

        $this->curr_status = $this->viewCurriculum->curr_status;

        $this->showViewModal = true;

        $this->curriculumTitle = "Curriculum Info";
    }

    public function makeBlankCurriculum() {
        return Curriculum::make();
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function edit(Curriculum $curriculum) {

        $this->resetErrorBag();

        if($this->editing->isNot($curriculum)) $this->editing = $curriculum;

        $this->showEditModal = true;

        $this->curriculumTitle = "Edit Curriculum";
    }

    public function save() {
        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;

        $this->alert('success', $this->curriculumTitle . ' ' . 'Successfully!');
    }

    public function delete($curriculum) {
        $this->deleteCurriculum = Curriculum::find($curriculum);

        $this->showDeleteModal = true;

        $this->curriculumTitle = "Delete Curriculum";
    }

    public function deleteCurriculum() {
        $this->deleteCurriculum->delete();

        $this->editing = $this->makeBlankCurriculum();

        $this->showDeleteModal = false;

        $this->alert('success', $this->curriculumTitle . ' ' . 'Successfully!');
    }


    public function render()
    {
        sleep(1);

        return view('livewire.curriculum-list', [
            'curricula' => Curriculum::search(['id', 'department_id', 'description', 'status'], $this->search)->orderBy($this->sortField, $this->sortDirection)->paginate(5),
            'departments' => Department::all(),

        ]);
    }
}
