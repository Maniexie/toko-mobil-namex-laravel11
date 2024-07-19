@extends('layouts.app')

@section('title', '| Customer')

@section('sidebar')
    @parent
@endsection

@section('content')


    <section class="section">
        <div class="row">

            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        {{-- <h5 class="card-title">Data Customer</h5> --}}
                        <h5 class="card-title d-flex justify-content-between align-items-center">
                            Data Customer
                            {{-- <a href="" class="btn btn-primary">Add Customer</a> --}}
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#formAddCustomer">
                                Add Customer
                            </button>
                        </h5>
                        <!-- Basic Modal -->
                        <div class="modal fade" id="formAddCustomer" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Form Add Customer</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <section class="section">
                                            <div class="row">
                                                <div class="col-lg-12">

                                                    <div class="card">
                                                        <div class="card-body">
                                                            <h5 class="card-title"></h5>

                                                            <!-- General Form Elements -->
                                                            <form action="{{ route('customer.store') }}" method="POST"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="row mb-3">
                                                                    <label for="inputNama"
                                                                        class="col-sm-2 col-form-label">Nama</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control"
                                                                            name="nama">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputEmail"
                                                                        class="col-sm-2 col-form-label">Email</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="email" class="form-control"
                                                                            name="email">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputPassword"
                                                                        class="col-sm-2 col-form-label">Password</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="password" class="form-control"
                                                                            name="password">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputNomorHp"
                                                                        class="col-sm-2 col-form-label">Nomor Hp</label>
                                                                    <div class="col-sm-10">
                                                                        <input type="text" class="form-control"
                                                                            name="nomor_hp">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputFoto"
                                                                        class="col-sm-2 col-form-label">Foto</label>
                                                                    <div class="col-sm-10">
                                                                        <input class="form-control" type="file"
                                                                            id="formFile" name="foto">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <label for="inputAlamat"
                                                                        class="col-sm-2 col-form-label">Alamat</label>
                                                                    <div class="col-sm-10">
                                                                        <textarea class="form-control" style="height: 100px" name="alamat"></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Close</button>
                                                                    <button class="btn btn-primary"
                                                                        type="submit">Submit</button>
                                                                </div>
                                                            </form><!-- End General Form Elements -->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>

                                    </div>
                                </div>
                            </div>
                        </div><!-- End Basic Modal-->

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <!-- Table with stripped rows -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Nomor HP</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cs)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $cs->nama }}</td>
                                        <td><img src="{{ asset('storage/uploads/' . $cs->foto) }}" alt="{{ $cs->nama }}"
                                                class="img-fluid" width="50px"></td>
                                        <td>{{ $cs->email }}</td>
                                        <td>{{ $cs->nomor_hp }}</td>
                                        <td>
                                            @if (strlen($cs->alamat) > 30)
                                                {{ substr($cs->alamat, 0, 30) }}...
                                                <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip"
                                                    title="{{ $cs->alamat }}">
                                                    <i class="ri-information-line"></i>
                                                </span>
                                            @else
                                                {{ $cs->alamat }}
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#formEditCustomer{{ $cs->id }}"><i
                                                    class="ri-eye-fill"></i></button>

                                            <form action="{{ route('customer.destroy', ['id' => $cs->id]) }}"
                                                method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this customer?')">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </form>
                                        </td>


                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- edit modal / update --}}
    @foreach ($customers as $cs)
        <div class="modal fade" id="formEditCustomer{{ $cs->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Form Edit Customer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title"></h5>
                                            <!-- form edit / update -->
                                            <form action="{{ route('customer.update', ['id' => $cs->id]) }}"
                                                method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT') <!-- Use PUT method for update -->
                                                <div class="row mb-3">
                                                    <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="nama"
                                                            value="{{ $cs->nama }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" name="email"
                                                            value="{{ $cs->email }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputPassword"
                                                        class="col-sm-2 col-form-label">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" name="password"
                                                            placeholder="*********" disabled>
                                                        <small>Leave blank if you do not want to change the password</small>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputNomorHp" class="col-sm-2 col-form-label">Nomor
                                                        Hp</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" name="nomor_hp"
                                                            value="{{ $cs->nomor_hp }}">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputFoto" class="col-sm-2 col-form-label">Foto</label>
                                                    <div class="col-sm-10">
                                                        <img id="previewImg{{ $cs->id }}"
                                                            src="{{ asset('storage/uploads/' . $cs->foto) }}"
                                                            alt="{{ $cs->nama }}" class="img-fluid mb-2"
                                                            style="height:150px; width:150px">
                                                        <input class="form-control" type="file"
                                                            id="formFile{{ $cs->id }}" name="foto"
                                                            onchange="previewImage(event, {{ $cs->id }})">
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <label for="inputAlamat"
                                                        class="col-sm-2 col-form-label">Alamat</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" style="height: 100px" name="alamat">{{ $cs->alamat }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button class="btn btn-primary" type="submit">Submit</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form><!-- End General Form Elements -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


    </div>

@endsection
<script>
    function previewImage(event, id) {
        const file = event.target.files[0];
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('previewImg' + id);
            output.src = reader.result;
        }
        reader.readAsDataURL(file);
    }
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
