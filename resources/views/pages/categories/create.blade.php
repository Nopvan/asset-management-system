@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ADD CATEGORY</h1>
    </div>

    {{-- Form Add Category --}}
    <div class="row">
        <div class="col">
            <form action="/category" method="POST">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="cat_name">Name</label>
                            <input type="text" name="cat_name" id="cat_name"
                                class="form-control @error('cat_name') is-invalid @enderror" value="{{ old('cat_name') }}">
                            @error('cat_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="cat_code">Code Category</label>
                            <input type="text" name="cat_code" id="cat_code" min="0"
                                class="form-control @error('cat_code') is-invalid @enderror" value="{{ old('cat_code') }}">
                            @error('cat_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="/category" class="btn btn-outline-secondary">
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
