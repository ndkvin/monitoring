@extends('layouts.dashboard')

@section('content')
    <div class="section-description section-description-inline">
        <h1>History</h1>
    </div>
    <!-- Button trigger modal -->
    <div class="d-flex">
        <button type="button" class="btn btn-primary my-3 me-3" data-bs-toggle="modal" data-bs-target="#create">
            Buat Kunjungan
        </button>
        <button type="button" class="btn btn-primary my-3 me-3" data-bs-toggle="modal" data-bs-target="#download">
            Export Data
        </button>
        <button type="button" class="btn btn-primary my-3 me-3" data-bs-toggle="modal"
            data-bs-target="#year-download-modal">
            Export Data
        </button>
    </div>
    <!-- create modal -->
    <div class="modal fade" id="create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kunjungan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fuel.store') }}" method="POST" id="formCreate" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Pengontrol" required">
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="check_date" class="form-label">Tanggal Pengecekan</label>
                            <input class="form-control flatpickr2" id="date" class="check_date" type="text"
                                name="check_date" placeholder="Select Date.." required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="usage" class="form-label">Total Jam Penggunaan</label>
                            <input type="number" step="0.01" class="form-control" id="usage" name="usage"
                                placeholder="Total Jam Penggunaan" required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="insert" class="form-label">Jumlah Solar Yang Dimasukan</label>
                            <input type="number" step="0.01" class="form-control" id="insert" name="insert"
                                placeholder="Jumlah Solar Yang Dimasukan" required>
                        </div>

                        <input type="submit" id="createSubmit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitCreate()">Create</button>
                </div>
            </div>
        </div>
    </div>
    <!-- export -->
    <div class="modal fade" id="download" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('export') }}" method="POST" id="formDownload" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mt-2">
                            <label for="check_date" class="form-label">Bulan</label>
                            <input class="form-control flatpickr2" id="month" class="check_date" type="text"
                                name="month" placeholder="Select Month" required>
                        </div>
                        <input type="submit" id="downloadSubmit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="download()">Download</button>
                </div>
            </div>
        </div>
    </div>
    <!-- export year -->
    <div class="modal fade" id="year-download-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Export Data Tahunan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('export-year') }}" method="POST" id="year-download"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12 mt-2">
                            <label for="check_date" class="form-label">Tahun</label>
                            <input class="form-control flatpickr2" id="year" class="check_date" type="text"
                                name="year" placeholder="Select Year" required>
                        </div>
                        <input type="submit" id="year-submit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="yearDownload()">Download</button>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table id="datatable4" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Tanggal Cek</th>
                        <th>Sisa Pertamina Dex Minggu Lalu</th>
                        <th>Sisa Pertamina Dex Sekarang</th>
                        <th>Penggunaan Minggu Lalu (Liter)</th>
                        <th>Penggunaan Minggu Lalu (Jam)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($fuels as $index => $fuel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $fuel->name }}</td>
                            <td>{{ $fuel->check_date }}</td>
                            <td>{{ $fuel->last }} Liter</td>
                            <td>{{ $fuel->current }} Liter</td>
                            <td>{{ $fuel->usage_liter }} Liter</td>
                            <td>{{ $fuel->usage }} Jam</td>
                            <td>
                                <button type="button" class="btn btn-primary btn-burger btn-sm me-3 mt-1"
                                    data-bs-toggle="modal" data-bs-target="#edit" data-id="{{ $fuel->id }}">
                                    <span
                                        class="material-symbols-outlined d-flex justify-content-center align-item-center">
                                        edit
                                    </span>
                                </button>

                                <button type="button" class="btn btn-danger btn-burger btn-sm me-3"
                                    data-bs-toggle="modal" data-bs-target="#delete" data-id="{{ $fuel->id }}">
                                    <span
                                        class="material-symbols-outlined d-flex justify-content-center align-item-center">
                                        delete
                                    </span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>Data Empty</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Anggota</th>
                        <th>Tanggal Cek</th>
                        <th>Sisa Bensin Minggu Lalu</th>
                        <th>Sisa Bensin Sekarang</th>
                        <th>Penggunaan Minggu Lalu (Liter)</th>
                        <th>Penggunaan Minggu Lalu (Jam)</th>
                        <th>Aksi</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="modal fade" id="edit" tab-index="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/fuel/id" method="POST" id="formEdit" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Pengontrol" required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="check_date" class="form-label">Tanggal Pengecekan</label>
                            <input class="form-control flatpickr2" id="dateEdit" class="check_date" type="text"
                                name="check_date" placeholder="Select Date.." required>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="usage" class="form-label">Total Jam Penggunaan</label>
                            <input type="number" step="0.01" class="form-control" id="usage" name="usage"
                                placeholder="Total Jam Penggunaan" required>
                        </div>


                        <div class="col-md-12 mt-2">
                            <label for="insert" class="form-label">Jumlah Solar Liter Dimasukan</label>
                            <input type="number" step="0.01" class="form-control" id="insert" name="insert"
                                placeholder="Jumlah Solar Yang Dimasukan" required>
                        </div>

                        <input type="submit" id="editSubmit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitEdit()">Edit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- delete modal -->
    <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Cashier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure to delete <span id="tanggal"></span>?
                    <form action="/fuel/id" method="POST" id="formCreate">
                        @method('DELETE')
                        @csrf
                        <input type="submit" id="deleteSubmit" class="d-none">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submitDelete()">Yes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $("#date").flatpickr({
            dateFormat: "Y-m-d",
        });

        $("#dateEdit").flatpickr({
            dateFormat: "Y-m-d",
        });

        $("#month").flatpickr({
            dateFormat: "Y-m",
        });

        $("#year").flatpickr({
            dateFormat: "Y",
        });

        function download() {
            $('#downloadSubmit').click();
        }

        function yearDownload() {
            $('#year-submit').click();
        }

        function submitCreate() {
            $('#createSubmit').click();
        }

        function submitEdit() {
            $('#editSubmit').click();
        }

        function submitDelete() {
            $('#deleteSubmit').click();
        }

        $('#edit').on('show.bs.modal', function(e) {
            let id = $(e.relatedTarget).data('id');
            let url = `/monitoring/public/fuel/${id}`;
            $.get(url, function(response) {
                console.log(response)
                $(e.currentTarget).find('form[action="/fuel/id"]').attr('action',
                    `/monitoring/public/fuel/${id}`);
                $(e.currentTarget).find('input[name="name"]').val(response.name);
                $(e.currentTarget).find('input[name="check_date"]').val(response.check_date);
                $(e.currentTarget).find('input[name="insert"]').val(response.insert);
                $(e.currentTarget).find('input[name="usage"]').val(response.usage);
            });
        });

        $('#delete').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            let url = `/monitoring/public/fuel/${id}`;
            console.log(url)
            $.get(url, function(response) {
                console.log(response)
                $(e.currentTarget).find('form[action="/fuel/id"]').attr('action',
                    `/monitoring/public/fuel/${id}`);
                $('#tanggal').text(response.check_date);
            });
        });
    </script>
@endsection
