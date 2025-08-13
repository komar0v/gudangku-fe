<?php

namespace App\Livewire\App\Inventory\Stocks;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class PantauStokBarang extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Stock Observer')]

    public $barangKeluarMasukToday, $lowStokItemCount, $supplierChart;
    public $namaSupplier, $barangMasuk;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchStatistics();
    }

    public function fetchStatistics()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $today = now('Asia/Jakarta')->format('Y-m-d');
            $res3 = $client->get('/api/super-admin/statistics/income-outcome-items/' . $today, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->barangKeluarMasukToday = json_decode($res3->getBody()->getContents(), true);

            $res4 = $client->get('/api/super-admin/manage/inventory/item/get-hampir-habis', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->lowStokItemCount = count(json_decode($res4->getBody()->getContents(), true));

            $res5 = $client->get('/api/super-admin/statistics/inventory/supplier/get-top5-pemasok', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->supplierChart = json_decode($res5->getBody()->getContents(), true);

            $this->namaSupplier = json_encode(collect($this->supplierChart)->pluck('nama_supplier'), true);
            $this->barangMasuk = json_encode(collect($this->supplierChart)->pluck('barang_masuk'), true);

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
        return view('livewire.app.inventory.stocks.pantau-stok-barang');
    }
}
