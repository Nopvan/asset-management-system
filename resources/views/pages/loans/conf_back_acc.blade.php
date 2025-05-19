@foreach ($loans as $loan)
    <!-- Modal Pengembalian -->
    <div class="modal fade" id="accBackModal-{{ $loan->id }}" tabindex="-1" aria-labelledby="accBackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="{{ route('item_loans.return', $loan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="accBackModalLabel">Form Pengembalian</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>User:</strong> {{ $loan->user->nama }}</p>
                        <p><strong>Item:</strong> {{ $loan->item->item_name }}</p>
                        <p><strong>Jumlah Dipinjam:</strong> {{ $loan->jumlah }}</p>
                        <p><strong>Ruangan Item:</strong> {{ $loan->item->room->name ?? '-' }}</p>
                        <p><strong>Keterangan:</strong> {{ $loan->keterangan ?? '-' }}</p>
                        <p><strong>Foto Barang Saat Dipinjam:</strong></p>
                        @if ($loan->photo_diterima)
                            <img src="{{ asset('storage/' . $loan->photo_diterima) }}" alt="Foto Diterima"
                                class="img-fluid rounded border" style="max-height: 200px;">
                        @else
                            <p><em>Tidak ada foto</em></p>
                        @endif

                        <div class="mb-3">
                            <label for="jumlah_kembali_{{ $loan->id }}" class="form-label">Jumlah Kembali</label>
                            <input type="number" name="jumlah_kembali" id="jumlah_kembali_{{ $loan->id }}"
                                class="form-control" required min="0" max="{{ $loan->jumlah }}">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_hilang_{{ $loan->id }}" class="form-label">Jumlah Hilang</label>
                            <input type="number" name="jumlah_hilang" id="jumlah_hilang_{{ $loan->id }}"
                                class="form-control" required min="0" max="{{ $loan->jumlah }}">
                        </div>
                        <div class="mb-3">
                            <label for="jumlah_rusak_{{ $loan->id }}" class="form-label">Jumlah Rusak</label>
                            <input type="number" name="jumlah_rusak" id="jumlah_rusak_{{ $loan->id }}"
                                class="form-control" required min="0" max="{{ $loan->jumlah }}">
                        </div>
                        <div class="mb-3">
                            <label for="photo_{{ $loan->id }}" class="form-label">Foto Saat Dikembalikan</label>
                            <input type="file" name="photo_kembali" id="photo_{{ $loan->id }}"
                                class="form-control" accept="image/*" required>
                        </div>
                        <div class="alert alert-warning" id="warning_{{ $loan->id }}" style="display: none;">
                            Total jumlah (kembali + hilang + rusak) tidak boleh lebih dari {{ $loan->jumlah }}.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kembalikan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const kembali{{ $loan->id }} = document.getElementById('jumlah_kembali_{{ $loan->id }}');
        const hilang{{ $loan->id }} = document.getElementById('jumlah_hilang_{{ $loan->id }}');
        const rusak{{ $loan->id }} = document.getElementById('jumlah_rusak_{{ $loan->id }}');
        const warning{{ $loan->id }} = document.getElementById('warning_{{ $loan->id }}');

        function validateJumlah() {
            const total = parseInt(kembali{{ $loan->id }}.value || 0) + parseInt(hilang{{ $loan->id }}.value ||
                0) + parseInt(rusak{{ $loan->id }}.value || 0);
            if (total > {{ $loan->jumlah }}) {
                warning{{ $loan->id }}.style.display = 'block';
            } else {
                warning{{ $loan->id }}.style.display = 'none';
            }
        }

        kembali{{ $loan->id }}.addEventListener('input', validateJumlah);
        hilang{{ $loan->id }}.addEventListener('input', validateJumlah);
        rusak{{ $loan->id }}.addEventListener('input', validateJumlah);
    </script>
@endforeach
