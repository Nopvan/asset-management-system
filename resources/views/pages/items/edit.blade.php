@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">EDIT ASSET</h1>
    </div>

    {{-- Form Edit Asset --}}
    <div class="row">
        <div class="col">
            <form action="/item/{{ $item->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-body">
                        <div class="form-group mb-3">
                            <label for="category">Category</label>
                            <input type="text" id="categorySearch" class="form-control mb-2"
                                placeholder="Search category..." value="{{ $item->category->cat_name ?? '' }}">
                            <select name="cat_id" id="category" class="form-control @error('cat_id') is-invalid @enderror"
                                style="display: none;">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('cat_id', $item->cat_id) == $category->id)>
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
                                value="{{ old('item_name', $item->item_name) }}">
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
                                    <option value="{{ $condition->value }}" @selected(old('conditions', $item->conditions) == $condition->value)>
                                        {{ $condition->label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="qty">Quantity</label>
                            <input type="number" name="qty" id="qty" min="0"
                                class="form-control @error('qty') is-invalid @enderror"
                                value="{{ old('qty', $item->qty) }}">
                            @error('qty')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="room_id">Room</label>
                            <input type="text" id="roomSearch" class="form-control" placeholder="Search room..."
                                value="{{ $item->room->name }}">
                            <select name="room_id" id="rooms"
                                class="form-control @error('room_id') is-invalid @enderror" style="display: none;">
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}" @selected(old('room_id', $item->room_id) == $room->id)>
                                        {{ trim($room->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('room_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="photo">Current Image</label><br>
                        @if ($item->photo)
                            <img src="{{ asset('storage/' . $item->photo) }}" width="150" class="img-thumbnail">
                        @else
                            <p><em>No image uploaded.</em></p>
                        @endif
                        <input type="file" name="photo" id="photo"
                            class="form-control @error('photo') is-invalid @enderror">
                        @error('photo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end" style="gap: 7px;">
                            <a href="/item" class="btn btn-outline-secondary">Back</a>
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

            .ui-menu-item-wrapper {
                padding: 8px 12px;
                cursor: pointer;
                color: #495057;
            }

            .ui-menu-item-wrapper:hover {
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
                let categoryData = $('#category option').map(function() {
                    return {
                        label: $(this).text().trim(),
                        value: $(this).val(),
                    };
                }).get();

                $('#categorySearch').autocomplete({
                    source: categoryData,
                    minLength: 1,
                    select: function(event, ui) {
                        $('#category').val(ui.item.value);
                        $('#categorySearch').val(ui.item.label);
                        return false;
                    }
                });

                let roomData = $('#rooms option').map(function() {
                    return {
                        label: $(this).text().trim(),
                        value: $(this).val(),
                    };
                }).get();

                $('#roomSearch').autocomplete({
                    source: roomData,
                    minLength: 1,
                    select: function(event, ui) {
                        $('#rooms').val(ui.item.value);
                        $('#roomSearch').val(ui.item.label);
                        return false;
                    }
                });
            });
        </script>
    @endpush
@endsection
