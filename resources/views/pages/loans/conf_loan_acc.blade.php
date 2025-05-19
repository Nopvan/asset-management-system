@foreach ($loans as $loan)
    @if ($loan->status == 'pending')
        <!-- Modal Acc -->
        <div class="modal fade" id="accModal-{{ $loan->id }}" tabindex="-1"
            aria-labelledby="accLabel-{{ $loan->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('item_loans.accept', $loan->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="accLabel-{{ $loan->id }}">Terima Peminjaman Barang</h5>
                            <button type="button" class="btn btn-default" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times"></i></button>
                        </div>
                        <div class="modal-body text-start">
                            <p><strong>Nama User:</strong> {{ $loan->user->nama }}</p>
                            <p><strong>Item:</strong> {{ $loan->item->item_name }}</p>
                            <p><strong>Jumlah:</strong> {{ $loan->jumlah }}</p>
                            <p><strong>Item berada di Ruangan:</strong>
                                {{ $loan->item->room->name ?? 'Tidak diketahui' }}
                            </p>
                            <p><strong>Keterangan:</strong> {{ $loan->keterangan ?? '-' }}</p>
                            <p><strong>Foto Barang Saat Diterima:</strong></p>
                            @if ($loan->photo_diterima)
                                <img src="{{ asset('storage/' . $loan->photo_diterima) }}" alt="Foto Diterima"
                                    class="img-fluid rounded border" style="max-height: 200px;">
                            @else
                                <p><em>Tidak ada foto</em></p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Terima</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endforeach
