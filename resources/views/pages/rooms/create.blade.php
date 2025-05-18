@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add Room</h1>
    </div>

    {{-- Form Add Room --}}
    <div class="row">
        <div class="col">
            <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Room Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="location_id">Location</label>
                            <input type="text" id="locationSearch" class="form-control" placeholder="Search location...">
                            <select name="location_id" id="location_id"
                                class="form-control @error('location_id') is-invalid @enderror" style="display: none;">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ old('location_id') == $location->id ? 'selected' : '' }}>
                                        {{ trim($location->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="area">Room Area (m²)</label>
                            <input type="number" name="area" id="area"
                                class="form-control @error('area') is-invalid @enderror" value="{{ old('area') }}">
                            @error('area')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo">Room Photo</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Available</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
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
                    setTimeout(() => {
                        btn.closest('form').submit();
                    }, 100);
                }
            </script>
        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <style>
            .ui-autocomplete {
                max-height: 200px;
                overflow-y: auto;
                overflow-x: hidden;
                background-color: #fff;
                border: 1px solid #ced4da;
                border-radius: 0.25rem;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                z-index: 1000;
            }

            .ui-autocomplete .ui-menu-item {
                padding: 8px 12px;
                cursor: pointer;
                color: #495057;
            }

            .ui-autocomplete .ui-menu-item:hover {
                background-color: #4e73df;
                color: #fff;
            }

            .ui-helper-hidden-accessible {
                display: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
        <script>
            $(document).ready(function() {
                // === LOCATION AUTOCOMPLETE ===
                let locationData = $('#location_id option').map(function() {
                    return {
                        label: $(this).text().trim(),
                        value: $(this).val(),
                    };
                }).get();

                $('#locationSearch').autocomplete({
                    source: locationData,
                    minLength: 1,
                    select: function(event, ui) {
                        $('#location_id').val(ui.item.value); // set ID
                        $('#locationSearch').val(ui.item.label); // show name
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
