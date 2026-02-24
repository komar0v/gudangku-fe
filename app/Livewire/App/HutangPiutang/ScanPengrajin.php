<?php

namespace App\Livewire\App\HutangPiutang;

use App\Livewire\Traits\RequireLogin;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class ScanPengrajin extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Scan')]

    public $successMessage, $errorMessage, $bulanIni;
    public $hutangDatas = null;
    public $hutangDatasOnCurrentMonth = null;
    public $qrResult = "default";
    public $pengrajinData, $listHutangBulanIni;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function fetchResult()
    {
        $this->qrResult;

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/pengrajin-barcode-search/' . $this->qrResult, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinData = json_decode($res1->getBody()->getContents(), true);

            if ($this->pengrajinData['is_found'] == true) {
                $this->fetchHutangData($this->qrResult);
            }
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

    public function fetchHutangData($pengrajinId)
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/hutang/pengrajin/' . $pengrajinId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $res2 = $client->get('api/hutang/pengrajin/'.$pengrajinId.'/current-month', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->hutangDatas = json_decode($res1->getBody()->getContents(), true);
            $this->hutangDatasOnCurrentMonth = json_decode($res2->getBody()->getContents(), true);
            $this->listHutangBulanIni = $this->hutangDatasOnCurrentMonth['data_hutang'];

            $this->bulanIni = Carbon::parse($this->hutangDatasOnCurrentMonth['current_month_year'])->translatedFormat('F Y');

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
        return view('livewire.app.hutang-piutang.scan-pengrajin');
    }
}
