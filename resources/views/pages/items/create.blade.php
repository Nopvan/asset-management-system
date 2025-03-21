    @extends('layouts.app')

    @section('content')
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">ADD ASSET</h1>
        </div>

        {{-- Form Add Asset --}}
        <div class="row">
            <div class="col">
                <form action="/item" method="POST">
                    @csrf
                    @method('POST')
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <label for="category">Category</label>
                                <select name="cat_id" id="category" class="form-control @error('cat_id')
                                    is-invalid
                                @enderror" value="{{ old('cat_id') }}">
                                    <option value="">-- Select Category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('cat_id') == $category->id)>{{ $category->cat_name }}</option>
                                    @endforeach
                                </select>
                            </div>    
                            <div class="form-group mb-3">
                                <label for="item_name">Name</label>
                                <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}">
                                @error('item_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>                    
                            <div class="form-group mb-3">
                                <label for="conditions">Condition</label>
                                <select name="conditions" id="conditions" class="form-control @error('conditions')
                                    is-invalid
                                @enderror">
                                <option value="">-- Select Condition --</option>
                                @foreach ([
                                    (object) [
                                        "label" => "Good",
                                        "value" => "good"
                                    ],
                                    (object) [
                                        "label" => "Lost",
                                        "value" => "lost"
                                    ],
                                    (object) [
                                        "label" => "Broken",
                                        "value" => "broken"
                                    ],
                                ] as $condition)
                                    <option value="{{ $condition->value }}" @selected (old('conditions') == $condition->value )>{{ $condition->label }}</option>
                                    
                                @endforeach
                                    {{-- <option value="good">Good</option>
                                    <option value="lost">Lost</option>
                                    <option value="broken">Broken</option> --}}
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="qty">Quantity</label>
                                <input type="number" name="qty" id="qty" min="0" class="form-control @error('qty') is-invalid @enderror" value="{{ old('qty') }}">
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="locations">Location</label>
                                <input type="text" name="locations" id="locations" class="form-control @error('locations') is-invalid @enderror" value="{{ old('locations') }}">
                                @error('locations')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-end"  style="gap: 7px;">
                                <a href="/item" class="btn btn-outline-secondary">
                                    Back
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Save
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    @endsection
        