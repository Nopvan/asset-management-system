<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confDelete-{{ $location->id }}" tabindex="-1"
    aria-labelledby="confDeleteLabel-{{ $location->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ url('/locations/' . $location->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confDeleteLabel-{{ $location->id }}">Delete Confirmation</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this location?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
