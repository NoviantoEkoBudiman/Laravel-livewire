<div class="container">
    <!-- START FORM -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <form>
            @if ($errors->any())
                <div class="pt-3">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @if (session()->has("message"))
                <div class="pt-3">
                    <div class="alert alert-success">
                        {{ session("message") }}
                    </div>
                </div>
            @endif
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" wire:model="email">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" wire:model="alamat">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-10">
                    @if ($updateData == false)
                        <button type="button" class="btn btn-primary" wire:click="store()">Simpan</button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click="update()">Update</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- AKHIR FORM -->

    <!-- START DATA -->
    <div class="my-3 p-3 bg-body rounded shadow-sm">
        <h1>Data Pegawai</h1>
        @if ($checked_employee_id)
            {{-- @php
                print_r($checked_employee_id)
            @endphp --}}
            <a class="btn btn-danger btn-sm" wire:click="deleteConfirmation('')" data-bs-toggle="modal" data-bs-target="#exampleModal">Hapus {{ count($checked_employee_id)." Data" }}</a>
        @endif
        <div class="py-3 px-3">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Search....." wire:model.live="katakunci">
                </div>
            </div>
        </div>
        <table class="table table-striped table-sortable">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class="col-md-1">No</th>
                    <th class="col-md-4 sort @if($sortName == 'nama') {{ $sortDirection }} @endif" wire:click="sort('nama')">Nama</th>
                    <th class="col-md-3 sort @if($sortName == 'email') {{ $sortDirection }} @endif" wire:click="sort('email')">Email</th>
                    <th class="col-md-2 sort @if($sortName == 'alamat') {{ $sortDirection }} @endif" wire:click="sort('alamat')">Alamat</th>
                    <th class="col-md-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if ($employees)
                    @foreach ($employees as $employee)
                        <tr>
                            <td><input type="checkbox" wire:key="{{ $employee->id }}" value="{{ $employee->id }}" wire:model.live="checked_employee_id"></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $employee->nama }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->alamat }}</td>
                            <td>
                                <a class="btn btn-warning btn-sm" wire:click="edit({{ $employee->id }})">Edit</a>
                                <a class="btn btn-danger btn-sm" wire:click="deleteConfirmation({{ $employee->id }})" data-bs-toggle="modal" data-bs-target="#exampleModal">Del</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {{ $employees->links() }}
    </div>
    <!-- AKHIR DATA -->
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Anda yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="delete()" data-bs-dismiss="modal">Hapus</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        Livewire.on('closeModal', () => {
            let modal = new bootstrap.Modal(document.getElementById('exampleModal'));
            modal.hide();
            document.getElementById('exampleModal').style.display = 'none';
        });
    </script> --}}
</div>