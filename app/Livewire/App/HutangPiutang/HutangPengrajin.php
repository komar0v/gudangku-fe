<?php

namespace App\Livewire\App\HutangPiutang;

use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class HutangPengrajin extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Hutang Pengrajin')]

    public $pengrajinLists;
    public $hutangDatas = null;
    public $pengrajinId;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
        $this->dispatch('init-slim-select2');
        $this->fetchDataPengrajin();
    }

    public function fetchDataPengrajin()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $resPengrajin = $client->get('/api/pengrajin-all-lite', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinLists = json_decode($resPengrajin->getBody()->getContents(), true);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {
                    session()->flash('error_message', $body->message);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function showData()
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $hutangDatas = $client->get('/api/hutang/pengrajin/'.$this->pengrajinId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->hutangDatas = json_decode($hutangDatas->getBody()->getContents(), true)['data'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 422) {
                    session()->flash('error_message', $body->message);
                    return;
                }
                else if ($response->getStatusCode() == 404) {
                    session()->flash('error_message', 'Data Tidak ditemukan. Periksa kembali.');
                    return;
                }
                else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.app.hutang-piutang.hutang-pengrajin');
    }
}
