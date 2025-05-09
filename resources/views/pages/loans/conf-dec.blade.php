<!-- Modal Decline -->
<div class="modal fade" id="confDec-{{ $borrow->id }}" tabindex="-1" aria-labelledby="confDecLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('borrow.reject', $borrow->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confDecLabel">Decline Confirmation</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to reject the return? (Lost / damaged item)
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject</button>
                </div>
            </div>
        </form>
    </div>
</div>
