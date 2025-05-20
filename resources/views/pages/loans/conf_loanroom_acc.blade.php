<!-- Modal Acc -->
<div class="modal fade" id="confAcc-{{ $loan->id }}" tabindex="-1" aria-labelledby="accLabel-{{ $loan->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('room_loans.accept', $loan->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi ACC Peminjaman Ruangan</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body text-start">
                    <p><strong>Nama Ruangan:</strong> {{ $loan->room->name }}</p>
                    <p><strong>Keterangan Peminjaman:</strong> {{ $loan->keterangan ?? '-' }}</p>

                    <p><strong>Foto Saat Diterima:</strong></p>
                    @if ($loan->photo_diterima)
                        <img src="{{ asset('storage/' . $loan->photo_diterima) }}" alt="Foto Diterima"
                            class="img-fluid rounded border" style="max-height: 200px;">
                    @else
                        <p><em>Tidak ada foto</em></p>
                    @endif

                    <hr>
                    <h6><strong>Daftar Item dalam Ruangan:</strong></h6>
                    @if ($loan->room->items->count() > 0)
                        <ul class="list-group">
                            @foreach ($loan->room->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->item_name }}
                                    <span>Jumlah: {{ $item->qty }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p><em>Tidak ada item dalam ruangan ini.</em></p>
                    @endif

                    <hr>
                    <p><strong>Yakin ingin menerima peminjaman ruangan ini?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">ACC</button>
                </div>
            </div>
        </form>
    </div>
</div>
