<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PettyCashBooks Controller
 *
 * @property \App\Model\Table\PettyCashBooksTable $PettyCashBooks
 */
class PettyCashBooksController extends AppController
{
    /**
     * 1. Buku kas: daftar transaksi + kolom Total (saldo berjalan).
     * Filter opsional: ?dari=2026-01-01&sampai=2026-01-31
     */
    public function index()
    {
        $dari = $this->request->getQuery('dari');
        $sampai = $this->request->getQuery('sampai');

        [$rows, $saldoAwalPeriode, $saldoAkhir] = $this->hitungSaldo($dari, $sampai);

        $this->set(compact('rows', 'saldoAwalPeriode', 'saldoAkhir', 'dari', 'sampai'));
    }

    /**
     * 2. Detail satu transaksi.
     */
    public function view($id = null)
    {
        $pettyCashBook = $this->PettyCashBooks->get($id);
        $this->set(compact('pettyCashBook'));
    }

    /**
     * 3. Tambah transaksi. no_urut diisi otomatis oleh Model (beforeSave).
     */
    public function add()
    {
        $pettyCashBook = $this->PettyCashBooks->newEmptyEntity();

        if ($this->request->is('post')) {
            $pettyCashBook = $this->PettyCashBooks->patchEntity($pettyCashBook, $this->request->getData());
            $pettyCashBook->is_create = $this->currentUserId();
            $pettyCashBook->is_active = '1';

            if ($this->PettyCashBooks->save($pettyCashBook)) {
                $this->Flash->success(__('Transaksi kas kecil berhasil disimpan.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Transaksi gagal disimpan. Periksa isian form.'));
        }
        $this->set(compact('pettyCashBook'));
    }

    /**
     * 4. Ubah transaksi. no_urut tidak ikut berubah.
     */
    public function edit($id = null)
    {
        $pettyCashBook = $this->PettyCashBooks->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            unset($data['no_urut']); // nomor input tidak boleh diubah dari form

            $pettyCashBook = $this->PettyCashBooks->patchEntity($pettyCashBook, $data);
            $pettyCashBook->is_update = $this->currentUserId();

            if ($this->PettyCashBooks->save($pettyCashBook)) {
                $this->Flash->success(__('Transaksi kas kecil berhasil diubah.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Transaksi gagal diubah. Periksa isian form.'));
        }
        $this->set(compact('pettyCashBook'));
    }

    /**
     * 5. Hapus (soft delete): data tidak benar-benar dihapus dari database.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $pettyCashBook = $this->PettyCashBooks->get($id);
        $pettyCashBook->is_active = '0';
        $pettyCashBook->is_delete = $this->currentUserId();
        $pettyCashBook->deleted = date('Y-m-d H:i:s');

        if ($this->PettyCashBooks->save($pettyCashBook)) {
            $this->Flash->success(__('Transaksi kas kecil berhasil dihapus.'));
        } else {
            $this->Flash->error(__('Transaksi gagal dihapus.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * 6. Halaman cetak (tanpa layout, siap di-print / Save as PDF dari browser).
     */
    public function cetak()
    {
        $dari = $this->request->getQuery('dari');
        $sampai = $this->request->getQuery('sampai');

        [$rows, $saldoAwalPeriode, $saldoAkhir] = $this->hitungSaldo($dari, $sampai);

        $this->viewBuilder()->setLayout('ajax'); // layout kosong bawaan CakePHP
        $this->set(compact('rows', 'saldoAwalPeriode', 'saldoAkhir', 'dari', 'sampai'));
    }

    /**
     * 7. Helper: hitung saldo berjalan.
     * Total = saldo sebelumnya + debet - kredit.
     *
     * @return array [baris, saldoAwalPeriode, saldoAkhir]
     */
    protected function hitungSaldo($dari = null, $sampai = null): array
    {
        $table = $this->PettyCashBooks;

        // Saldo yang dibawa dari sebelum periode filter
        $saldo = 0.0;
        if (!empty($dari)) {
            $prev = $table->find()
                ->select([
                    'total_debet' => 'SUM(PettyCashBooks.debet)',
                    'total_kredit' => 'SUM(PettyCashBooks.kredit)',
                ])
                ->where([
                    'PettyCashBooks.is_active' => '1',
                    'PettyCashBooks.tgl_input <' => $dari,
                ])
                ->first();
            $saldo = (float) ($prev->total_debet ?? 0) - (float) ($prev->total_kredit ?? 0);
        }
        $saldoAwalPeriode = $saldo;

        $query = $table->find()
            ->where(['PettyCashBooks.is_active' => '1'])
            ->order(['PettyCashBooks.tgl_input' => 'ASC', 'PettyCashBooks.id' => 'ASC']);

        if (!empty($dari)) {
            $query->where(['PettyCashBooks.tgl_input >=' => $dari]);
        }
        if (!empty($sampai)) {
            $query->where(['PettyCashBooks.tgl_input <=' => $sampai]);
        }

        // Semua baris diambil tanpa paginate(), supaya saldo tidak salah
        $rows = $query->all()->toList();

        foreach ($rows as $row) {
            $saldo += (float) $row->debet - (float) $row->kredit;
            $row->total = $saldo;
        }

        return [$rows, $saldoAwalPeriode, $saldo];
    }

    /**
     * Bukan method halaman. Mengambil id user yang sedang login
     * untuk kolom is_create / is_update / is_delete.
     */
    protected function currentUserId()
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity) {
            return (string) $identity->get('id');
        }

        return (string) $this->request->getSession()->read('Auth.id');
    }
}