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
    #[Title('Stats Observer')]

    public $ambilKembaliToday, $top10PengrajinToday;
    public $stokTipisCount;
    public $pluckAmbil, $pluckKembali, $pluckPengrajin;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchStatistics();
    }

    public function fetchStatistics()
    {

        $today = now('Asia/Jakarta')->format('Y-m-d');

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res3 = $client->get('/api/count/transactions/on-a-day/' . $today, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->ambilKembaliToday = json_decode($res3->getBody()->getContents(), true);

            $res4 = $client->get('/api/count/stocks/get-stok-barang-tipis/' . env('APP_STOCK_TRESHOLD'), [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->stokTipisCount = json_decode($res4->getBody()->getContents(), true)['total_items'];

            $res5 = $client->get('/api/super-admin/statistics/graph/getTop10PengrajinOnDate?date='.$today, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->top10PengrajinToday = json_decode($res5->getBody()->getContents(), true);
            $this->pluckAmbil = json_encode(collect($this->top10PengrajinToday)->pluck('ambil'), true);
            $this->pluckKembali = json_encode(collect($this->top10PengrajinToday)->pluck('kembali'), true);
            $this->pluckPengrajin = json_encode(collect($this->top10PengrajinToday)->pluck('nama_pengrajin'), true);
            
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
