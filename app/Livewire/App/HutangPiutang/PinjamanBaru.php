<?php

namespace App\Livewire\App\HutangPiutang;

use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class PinjamanBaru extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Peminjaman Baru')]

    public $pengrajinDatas;
    public $pengrajinId;
    public $nominal, $keterangan = null;

    public function mount($pengrajinId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchData($pengrajinId);
    }

    public function fetchData($pengrajinId)
    {
        $this->pengrajinId = $pengrajinId;
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/pengrajin-details-lite/' . $pengrajinId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->pengrajinDatas = json_decode($res1->getBody()->getContents(), true);
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
                } else if ($response->getStatusCode() == 404) {
                    session()->flash('error_message', 'Data Tidak ditemukan. Periksa kembali.');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function pinjamUang()
    {

        $this->validate([
            'nominal' => 'required|numeric|min:1',
            'keterangan'   => 'nullable|string|max:255'
        ]);

        $data = [
            'pengrajin_id' => $this->pengrajinId,
            'nominal' => preg_replace('/[^0-9]/', '', $this->nominal),
            'keterangan' => $this->keterangan
        ];
        
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->post('/api/hutang/pinjam', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],'json' => $data
            ]);

            $responseData = json_decode($res1->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

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
                } else if ($response->getStatusCode() == 404) {
                    session()->flash('error_message', 'Data Tidak ditemukan. Periksa kembali.');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function setNominal($amount)
    {
        $this->nominal = number_format($amount, 0, ',', '.');
    }

    public function formatNominal()
    {
        $clean = preg_replace('/[^0-9]/', '', $this->nominal);
        $this->nominal = number_format($clean, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.app.hutang-piutang.pinjaman-baru');
    }
}
