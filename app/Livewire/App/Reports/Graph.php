<?php

namespace App\Livewire\App\Reports;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Graph extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Graph')]

    public $graphKeluarMasuk, $graphSupplier, $graphKategori;
    public $period;
    public $namaSupplier, $totalMasuk;
    public $kategoriMasuk, $kategoriKeluar;
    public $namKatMasuk, $jumMasuk;
    public $namKatKeluar, $jumKeluar;

    public function mount($date)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $periode = IndoDateFormat::formatIndo($date);
            $parts = explode(' ', $periode);
            $this->period = $parts[1] . ' ' . $parts[2];
        } catch (\Exception $e) {
            session()->flash('error_message', 'Format tanggal invalid.');
            return $this->redirectRoute('appReportPage', navigate: true);
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/statistics/inventory/reports/' . $date, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->graphKeluarMasuk = json_decode($res1->getBody()->getContents(), true);

            $res2 = $client->get('/api/super-admin/statistics/suppliers/reports/' . $date . '/get-top10-pemasok', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->graphSupplier = json_decode($res2->getBody()->getContents(), true);

            $this->namaSupplier = json_encode(collect($this->graphSupplier)->pluck('nama_supplier'), true);
            $this->totalMasuk = json_encode(collect($this->graphSupplier)->pluck('total_barang_masuk'), true);

            $res3 = $client->get('/api/super-admin/statistics/inventory/reports/' . $date . '/get-categories', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->graphKategori = json_decode($res3->getBody()->getContents(), true);

            $this->kategoriMasuk = $this->graphKategori['barang_masuk'];
            $this->namKatMasuk = json_encode(collect($this->kategoriMasuk)->pluck('nama_kategori'), true);
            $this->jumMasuk = json_encode(collect($this->kategoriMasuk)->pluck('total'), true);

            $this->kategoriKeluar = $this->graphKategori['barang_keluar'];
            $this->namKatKeluar = json_encode(collect($this->kategoriKeluar)->pluck('nama_kategori'), true);
            $this->jumKeluar = json_encode(collect($this->kategoriKeluar)->pluck('total'), true);

        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.app.reports.graph');
    }
}
