@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EDIT ROOM</h1>
    </div>

    {{-- Form Edit Room --}}
    <div class="row">
        <div class="col">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="name">Room Name</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $room->name) }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="location_id">Location</label>
                            <select name="location_id" id="location_id"
                                class="form-control @error('location_id') is-invalid @enderror">
                                @foreach ($locations as $location)
                                    <option value="{{ $location->id }}"
                                        {{ $room->location_id == $location->id ? 'selected' : '' }}>
                                        {{ $location->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="area">Area (m²)</label>
                            <input type="number" name="area" id="area" min="0"
                                class="form-control @error('area') is-invalid @enderror"
                                value="{{ old('area', $room->area) }}">
                            @error('area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select name="status" id="status"
                                class="form-control @error('status') is-invalid @enderror">
                                <option value="1" {{ old('status', $room->status) == '1' ? 'selected' : '' }}>Available
                                </option>
                                <option value="0" {{ old('status', $room->status) == '0' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo">Update Photo (optional)</label>
                            <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if ($room->photo)
                                <div class="mt-2">
                                    <small>Current Photo:</small><br>
                                    <img src="{{ asset('storage/' . $room->photo) }}" alt="{{ $room->name }}"
                                        class="img-thumbnail" style="max-height: 100px;">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">Back</a>
                            <button type="submit" class="btn btn-warning" onclick="disableSubmit(this)">
                                Save Changes
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
@endsection
