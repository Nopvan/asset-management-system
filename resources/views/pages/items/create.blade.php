@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">ADD ASSET</h1>
    </div>

    {{-- Form Add Asset --}}
    <div class="row">
        <div class="col">
            <form action="/item" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <input type="text" class="form-control" id="categorySearch" placeholder="Search category...">
                            <select name="cat_id" id="category" class="form-control @error('cat_id') is-invalid @enderror"
                                style="display: none;">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('cat_id') == $category->id)>
                                        {{ trim($category->cat_name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="item_name">Name</label>
                            <input type="text" name="item_name" id="item_name"
                                class="form-control @error('item_name') is-invalid @enderror"
                                value="{{ old('item_name') }}">
                            @error('item_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="conditions">Condition</label>
                            <select name="conditions" id="conditions"
                                class="form-control @error('conditions') is-invalid @enderror">
                                <option value="">-- Select Condition --</option>
                                @foreach ([(object) ['label' => 'Good', 'value' => 'good'], (object) ['label' => 'Lost', 'value' => 'lost'], (object) ['label' => 'Broken', 'value' => 'broken']] as $condition)
                                    <option value="{{ $condition->value }}" @selected(old('conditions') == $condition->value)>
                                        {{ $condition->label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('conditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" id="qty" min="0"
                                class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="room_id">Room</label>
                            <input type="text" class="form-control" id="roomSearch" placeholder="Search room...">
                            <select name="room_id" id="room_id"
                                class="form-control @error('room_id') is-invalid @enderror" style="display: none;">
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @selected(old('room_id') == $room->id)>
                                        {{ trim($room->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="photo">Upload Foto</label>
                            <input type="file" name="photo" id="photo"
                                class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="/item" class="btn btn-outline-secondary">Back</a>
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
                // === CATEGORY ===
                let categoryData = $('#category option').map(function() {
                    return {
                        label: $(this).text().trim(), // tampilkan ke user
                        value: $(this).val(), // dikirim ke server
                    };
                }).get();

                $('#categorySearch').autocomplete({
                    source: categoryData,
                    minLength: 1,
                    select: function(event, ui) {
                        $('#category').val(ui.item.value); // set ID ke select hidden
                        $('#categorySearch').val(ui.item.label); // tampilkan label di input
                        return false;
                    }
                });

                // === ROOM ===
                let roomData = $('#room_id option').map(function() {
                    return {
                        label: $(this).text().trim(),
                        value: $(this).val(),
                    };
                }).get();

                $('#roomSearch').autocomplete({
                    source: roomData,
                    minLength: 1,
                    select: function(event, ui) {
                        $('#room_id').val(ui.item.value);
                        $('#roomSearch').val(ui.item.label);
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
