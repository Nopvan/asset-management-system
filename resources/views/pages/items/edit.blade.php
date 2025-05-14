@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EDIT ASSET</h1>
    </div>

    {{-- Form Add Asset --}}
    <div class="row">
        <div class="col">
            <form action="/item/{{ $item->id }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <select name="cat_id" id="category"
                                class="form-control @error('cat_id')
                                is-invalid
                            @enderror"
                                value="{{ old('cat_id') }}">
                                <option selected disabled>-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('cat_id', $item->cat_id) == $category->id)>
                                        {{ $category->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="item_name">Name</label>
                            <input type="text" name="item_name" id="item_name"
                                class="form-control @error('item_name') is-invalid @enderror"
                                value="{{ old('item_name', $item->item_name) }}">
                            @error('item_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="conditions">Condition</label>
                            <select name="conditions" id="conditions"
                                class="form-control @error('conditions')
                                is-invalid
                            @enderror">
                                <option value="">-- Select Condition --</option>
                                @foreach ([
            (object)
    [
                'label' => 'Good',
                'value' => 'good',
            ],
            (object) [
                'label' => 'Lost',
                'value' => 'lost',
            ],
            (object) [
                'label' => 'Broken',
                'value' => 'broken',
            ],
        ] as $condition)
                                    <option value="{{ $condition->value }}" @selected(old('conditions', $item->conditions) == $condition->value)>
                                        {{ $condition->label }}</option>
                                @endforeach
                                {{-- <option value="good">Good</option>
                                <option value="lost">Lost</option>
                                <option value="broken">Broken</option> --}}
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" id="qty" min="0"
                                class="form-control @error('qty') is-invalid @enderror"
                                value="{{ old('qty', $item->qty) }}">
                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="rooms">Ruangan</label>
                            <select name="room_id" id="rooms"
                                class="form-control @error('room_id') is-invalid @enderror">
                                value="{{ old('rooms') }}">
                                <option selected disabled>-- Select Room --</option>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @selected(old('rooms', $item->room_id) == $room->id)>
                                        {{ $room->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="/item" class="btn btn-outline-secondary">
                                Back
                            </a>
                            <button type="submit" class="btn btn-warning" onclick="disableSubmit(this)">
                                Save Change
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
