<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Models\Curriculum;
use App\Models\Department;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class StudentList extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $search = '';

    public $sortField = 'id';

    public $sortDirection = 'desc';

    public $showResults = '5';

    public $userTitle;

    public $disableUser;

    public $viewUser;

    public $editUser;

    public $currentUser;

    // Viewing User Info
    public $userId;
    public $firstName;
    public $middleName;
    public $lastName;
    public $gender;
    public $studentId;
    public $departmentId;
    public $curriculumId;
    public $email;
    public $emailStatus;
    public $accStatus;
    public $yearLevel;
    public $createdAt;

    public $curriculaOption;

    // Modals
    public $showDeleteModal = false;
    public $showEditModal = false;
    public $showViewModal = false;

    // Editing Table
    public User $editing;

    protected function rules() { 
        return [
        'editing.first_name' => 'required|regex:/^[\pL\s]+$/u|min:2',
        'editing.middle_name' => 'required|regex:/^[\pL\s]+$/u|min:2',
        'editing.last_name' => 'required|regex:/^[\pL\s]+$/u|min:2',
        'editing.gender' => 'required',
        'editing.student_id' => 'required|numeric|digits:7|unique:users,student_id,' . $this->userId,
        'editing.year_level' => 'required',
        'editing.department_id' => 'required',
        'editing.curriculum_id' => 'required',
        'editing.email' => 'required|email|unique:users,email,' . $this->userId,
        ];
}

    public function mount() {
        $this->editing = $this->makeBlankUser();

        $this->curriculaOption = [];

    }

    public function displayCurriculumOption() {
        if($this->editing->department_id != '') {
            $this->curriculaOption = Curriculum::where('department_id', $this->editing->department_id)->where('curr_status', '1')->get();
        } else {
            $this->curriculaOption = [];
        }
    }

    public function updatedEditingDepartmentId() {
        if($this->editing->department_id != '') {
            $this->curriculaOption = Curriculum::where('department_id', $this->editing->department_id)->where('curr_status', '1')->get();
        }
    }

    public function closeModal() {

        $this->showEditModal = false;

    }

    public function create() {
        $this->resetErrorBag();

        $this->userId = '';

        if ($this->editing->getKey()) $this->editing = $this->makeBlankUser();

        $this->showEditModal = true;

        $this->userTitle = "Add Student Account";

        $this->displayCurriculumOption();

    }

    public function view($user) {
        $this->viewUser = User::find($user);

        $this->userId = $this->viewUser->id;

        $this->firstName = $this->viewUser->first_name;

        $this->middleName = $this->viewUser->middle_name;

        $this->lastName = $this->viewUser->last_name;

        $this->gender = $this->viewUser->gender;

        $this->studentId = $this->viewUser->student_id;

        $this->departmentId = $this->viewUser->department_id;

        $this->curriculumId = $this->viewUser->curriculum_id;

        $this->email = $this->viewUser->email;

        $this->emailStatus = $this->viewUser->email_status;

        $this->accStatus = $this->viewUser->acc_status;

        $this->yearLevel = $this->viewUser->year_level;

        $this->createdAt = $this->viewUser->created_at;

        $this->showViewModal = true;

        $this->userTitle = "Student Account Info";
    }

    public function makeBlankUser() {
        return User::make();
    }

    public function sortBy($field) {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function edit(User $user) {
        $this->resetErrorBag();

        $this->userId = $user->id;

        // $this->editUser = User::find($user);
        
        if($this->editing->isNot($user)) $this->editing = $user;
        
        $this->showEditModal = true;
        
        $this->userTitle = "Edit Student Account";

        $this->displayCurriculumOption();
    }

    public function save() {
        
        $this->validate();
        
        $this->userId = $this->editing->id;
        
        $this->editing->save();
        
        $this->editing->sendEmailVerificationNotification();

        $this->currentUser = User::find($this->editing->id);

        if($this->currentUser->year_level == '1st Year' || $this->currentUser->year_level == '2nd Year' || $this->currentUser->year_level == '3rd Year') {
            $this->currentUser->assignRole('Regular Students');
        }

        if($this->currentUser->year_level == '4th Year') {
            $this->currentUser->assignRole('Graduating Students (Pending Thesis)');
        }
        

        $this->showEditModal = false;

        $this->alert('success', $this->userTitle . ' ' . 'Successfully!');
    }

    public function disable($user) {
        $this->disableUser = User::find($user);

        $this->showDeleteModal = true;

        $this->accStatus = $this->disableUser->acc_status;

        if($this->disableUser->acc_status) {
            $this->userTitle = "Deactivate Student Account";
        } else {
            $this->userTitle = "Activate Student Account";
        }

    }

    public function disableUser() {

        if($this->disableUser->acc_status) {
            $this->disableUser->acc_status = '0';
        } else {
            $this->disableUser->acc_status = '1';
        }

        $this->disableUser->save();

        $this->editing = $this->makeBlankUser();

        $this->showDeleteModal = false;

        $this->alert('success', $this->userTitle . ' ' . 'Successfully!');
    }

    public function render()
    {

        return view('livewire.student-list', [
            'users' => User::leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('curricula', 'users.curriculum_id', '=', 'curricula.id')
            ->where('student_id', 'like', '%'  . $this->search . '%')
            ->orWhere('last_name', 'like', '%'  . $this->search . '%')
            ->orWhere('first_name', 'like', '%'  . $this->search . '%')
            ->orWhere('year_level', 'like', '%'  . $this->search . '%')
            ->orWhere('dept_name', 'like', '%'  . $this->search . '%')
            ->orWhere('curr_name', 'like', '%'  . $this->search . '%')
            ->select('users.id', 'users.first_name', 'users.middle_name', 'users.last_name', 'users.gender', 'users.email_status', 'users.acc_status', 'users.student_id', 'users.department_id', 'users.curriculum_id', 'users.year_level', 'users.created_at', 'departments.dept_name', 'departments.dept_description', 'curricula.curr_name', 'curricula.curr_description')
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->showResults),
            'departments' => Department::all()->where('dept_status', '1'),
            'curricula' => Curriculum::all(),
        ]);
    }
}
