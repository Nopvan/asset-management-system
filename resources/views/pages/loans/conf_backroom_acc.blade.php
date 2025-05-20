<div class="modal fade" id="confReturn-{{ $loan->id }}" tabindex="-1" aria-labelledby="returnLabel-{{ $loan->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('room_loans.return', $loan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pengembalian Ruangan</h5>
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body text-start">
                    <p><strong>Nama Ruangan:</strong> {{ $loan->room->name }}</p>
                    <p><strong>Keterangan Peminjaman:</strong> {{ $loan->keterangan ?? '-' }}</p>

                    <p><strong>Foto Saat Diterima:</strong></p>
                    @if ($loan->photo_diterima)
                        <img src="{{ asset('storage/' . $loan->photo_diterima) }}" class="img-fluid rounded border"
                            style="max-height: 200px;">
                    @else
                        <p><em>Tidak ada foto</em></p>
                    @endif

                    <hr>
                    <h6><strong>Daftar Item dalam Ruangan:</strong></h6>
                    @if ($loan->room->items->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Jumlah</th>
                                        <th>Kembali</th>
                                        <th>Hilang</th>
                                        <th>Rusak</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loan->itemLoans as $itemLoan)
                                        <tr>
                                            <td>{{ $itemLoan->item->item_name }}</td>
                                            <td>{{ $itemLoan->jumlah }}</td>
                                            <td>
                                                <input type="number" id="jumlah_kembali_{{ $itemLoan->id }}"
                                                    name="items[{{ $itemLoan->item->id }}][kembali]"
                                                    class="form-control" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" id="jumlah_hilang_{{ $itemLoan->id }}"
                                                    name="items[{{ $itemLoan->item->id }}][hilang]"
                                                    class="form-control" min="0" required>
                                            </td>
                                            <td>
                                                <input type="number" id="jumlah_rusak_{{ $itemLoan->id }}"
                                                    name="items[{{ $itemLoan->item->id }}][rusak]" class="form-control"
                                                    min="0" required>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <div id="warning_{{ $itemLoan->id }}" style="display:none; color:red;">
                                                    Jumlah tidak boleh melebihi
                                                    {{ $itemLoan->jumlah }}.
                                                </div>
                                            </td>
                                        </tr>

                                        <script>
                                            const kembali{{ $itemLoan->id }} = document.getElementById('jumlah_kembali_{{ $itemLoan->id }}');
                                            const hilang{{ $itemLoan->id }} = document.getElementById('jumlah_hilang_{{ $itemLoan->id }}');
                                            const rusak{{ $itemLoan->id }} = document.getElementById('jumlah_rusak_{{ $itemLoan->id }}');
                                            const warning{{ $itemLoan->id }} = document.getElementById('warning_{{ $itemLoan->id }}');

                                            function validateJumlah{{ $itemLoan->id }}() {
                                                const total = parseInt(kembali{{ $itemLoan->id }}.value || 0) +
                                                    parseInt(hilang{{ $itemLoan->id }}.value || 0) +
                                                    parseInt(rusak{{ $itemLoan->id }}.value || 0);
                                                if (total > {{ $itemLoan->jumlah }}) {
                                                    warning{{ $itemLoan->id }}.style.display = 'block';
                                                } else {
                                                    warning{{ $itemLoan->id }}.style.display = 'none';
                                                }
                                            }

                                            kembali{{ $itemLoan->id }}.addEventListener('input', validateJumlah{{ $itemLoan->id }});
                                            hilang{{ $itemLoan->id }}.addEventListener('input', validateJumlah{{ $itemLoan->id }});
                                            rusak{{ $itemLoan->id }}.addEventListener('input', validateJumlah{{ $itemLoan->id }});
                                        </script>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p><em>Tidak ada item dalam ruangan ini.</em></p>
                    @endif

                    <hr>
                    <div class="mb-3">
                        <label for="photo_dikembalikan_{{ $loan->id }}" class="form-label">Foto Saat
                            Dikembalikan</label>
                        <input type="file" name="photo_dikembalikan" id="photo_dikembalikan_{{ $loan->id }}"
                            class="form-control" accept="image/*" required>
                    </div>

                    <p><strong>Yakin ingin mengkonfirmasi pengembalian ruangan ini?</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi Pengembalian</button>
                </div>
            </div>
        </form>
    </div>
</div>
