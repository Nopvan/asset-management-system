@extends('layouts.app')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">CATEGORIES</h1>
            <a href="/category/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Category</a>
    </div>
    
    {{-- Table --}}
<div class="row">
    <div class="col">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered text-center" id="dataTable">
                        <thead> 
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th></th>
                            </tr>
                        </thead>
                        @if (count($categories) < 1)
                        <tbody>
                            <tr>
                                <td colspan="11">
                                    <span>Data Not Found</span>
                                </td>
                            </tr>
                        </tbody>
                        @else
                        <tbody>
                            @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->cat_name }}</td>
                                <td>{{ $category->cat_code }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning mx-1">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger mx-1" data-bs-toggle="modal" data-bs-target="#confDelete-{{ $category->id }}">
                                            <i class="fas fa-eraser"></i>
                                        </button>
                                    </div>
                                </td>
                                @include('pages.categories.conf-delete')
                                @endforeach
                            </tr>
                        </tbody>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
