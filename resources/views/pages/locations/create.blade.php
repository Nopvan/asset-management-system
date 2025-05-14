    @extends('layouts.app')

    @section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Add Location</h1>
        </div>

        {{-- Form Add Asset --}}
        <div class="row">
            <div class="col">
                <form action="/locations" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="qty">Address</label>
                                <input type="text" name="address" id="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="area">Area (m²)</label>
                                <input type="number" name="area" id="area"
                                    class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}">
                                @error('area')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="photo">Upload Foto</label>
                                <input type="file" name="photo"
                                    class="form-control @error('photo') is-invalid @enderror">
                                @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end" style="gap: 7px;">
                                    <a href="/locations" class="btn btn-outline-secondary">
                                        Back
                                    </a>
                                    <button type="submit" class="btn btn-primary" onclick="disableSubmit(this)">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </div>
                </form>
                <script>
                    document.querySelector('form').addEventListener('keydown', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                        }
                    });

                    function disableSubmit(btn) {
                        btn.disabled = true;
                        btn.innerHTML =
                            `<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...`;
                        // Kirim form secara eksplisit
                        setTimeout(() => {
                            btn.closest('form').submit();
                        }, 100); // Tunggu sebentar sebelum form disubmit
                    }
                </script>
            </div>
        </div>
    @endsection
