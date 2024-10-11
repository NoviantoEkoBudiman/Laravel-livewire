<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Employee as EmployeeModel;
use Livewire\WithPagination;

class Employee extends Component
{
    use WithPagination;
    protected $paginationTheme = "bootstrap";
    public $nama;
    public $email;
    public $alamat;
    public $employeeId;
    public $updateData = false;
    public $katakunci;
    public $checked_employee_id = [];
    public $sortName = "nama";
    public $sortDirection = "asc";

    public function render()
    {
        if (empty($this->katakunci)) {
            $data = EmployeeModel::orderBy($this->sortName,$this->sortDirection)->paginate(min(EmployeeModel::count(),10));
        }else{
            $this->resetPage();
            $data = EmployeeModel::where("nama","like","%".$this->katakunci."%")
                    ->orWhere("email","like","%".$this->katakunci."%")
                    ->orWhere("alamat","like","%".$this->katakunci."%")
                    ->orderBy($sortName,$sortDirection)
                    ->paginate(min(EmployeeModel::count(),10));
        }
        return view('livewire.employee', ["employees" => $data]);
    }

    function sort($columnName)
    {
        $this->sortName = $columnName;
        $this->sortDirection = $this->sortDirection == "asc" ? "desc" : "asc";
    }

    public function store()
    {
        $rules = [
            "nama"      => "required",
            "email"     => "required|email|unique:employees",
            "alamat"    => "required"
        ];
        $messages = [
            "nama.required"     =>  "Nama tidak boleh kosong",
            "email.required"    =>  "Email tidak boleh kosong",
            "email.email"       =>  "Format email salah",
            "email.unique"      =>  "Email sudah dipakai",
            "alamat.required"   =>  "Alamat tidak boleh kosong"
        ];
        $validate = $this->validate($rules, $messages);
        EmployeeModel::create($validate);
        session()->flash("message","Data berhasil disimpan");
    }

    function edit($id)
    {
        $data = EmployeeModel::find($id);
        $this->nama         = $data->nama;
        $this->email        = $data->email;
        $this->alamat       = $data->alamat;
        $this->updateData   = true;
        $this->employeeId   = $id;
    }

    function update()
    {
        $data = EmployeeModel::find($this->employeeId);
        $rules = [
            "nama"      =>  "required",
            "email"     => "required|email|unique:employees,email,".$this->employeeId,
            "alamat"    =>  "required"
        ];
        $messages = [
            "nama.required"     =>  "Nama tidak boleh kosong",
            "email.required"    =>  "Email tidak boleh kosong",
            "email.email"       =>  "Format email salah",
            "email.unique"      =>  "Email sudah dipakai",
            "alamat.required"   =>  "Alamat tidak boleh kosong"
        ];
        $validate = $this->validate($rules, $messages);
        $data->update($validate);
        $this->clear();
        session()->flash("message","Data berhasil diupdate");
    }

    function clear()
    {
        $this->nama = "";
        $this->email = "";
        $this->alamat = "";
        $this->employeeId = "";
        $this->updateData = false;
    }

    function deleteConfirmation($id)
    {
        if(!empty($id)){
            $this->employeeId = $id;
        }
    }

    function delete()
    {
        if(!empty($this->employeeId)){
            $data = EmployeeModel::find($this->employeeId);
            if($data){
                $data->delete();
            }
            $this->employeeId = null;
            // $this->dispatch('closeModal');
        }
        if(!empty($this->checked_employee_id)){
            for ($i=0; $i < count($this->checked_employee_id); $i++) { 
                $datas = EmployeeModel::find($this->checked_employee_id[$i]);
                if($datas){
                    $datas->delete();
                }
            }
            $this->checked_employee_id = null;
        }
        session()->flash("message","Data berhasil dihapus");
    }
}
