<!-- Modal ACC -->
<div class="modal fade" id="confAcc-{{ $borrow->id }}" tabindex="-1" aria-labelledby="confAccLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('borrow.confirm', $borrow->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confAccLabel">Return Confirmation</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to agree to return this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Acc</button>
                </div>
            </div>
        </form>
    </div>
</div>
