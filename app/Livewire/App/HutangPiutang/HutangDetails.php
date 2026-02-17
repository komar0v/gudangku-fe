<?php

namespace App\Livewire\App\HutangPiutang;

use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class HutangDetails extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Debt Details')]

    public $detailHutang;
    public $persen = 0;
    public $jumlah_bayar, $keterangan;

    public function mount($transactionId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->fetchData($transactionId);
    }

    public function fetchData($transactionId)
    {
        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/hutang/trx/' . $transactionId . '/details', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->detailHutang = json_decode($res->getBody()->getContents(), true)['data'];

            $this->persen = ($this->detailHutang['total_hutang'] > 0)
                ? (($this->detailHutang['total_hutang'] - $this->detailHutang['sisa_hutang']) / $this->detailHutang['total_hutang']) * 100
                : 0;
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

    public function payDebt()
    {
        $this->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
            'keterangan'   => 'nullable|string|max:255'
        ]);

        $data = [
            'hutang_id' => $this->detailHutang['id'],
            'jumlah_bayar' => $this->jumlah_bayar,
            'keterangan' => $this->keterangan
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/hutang/bayar', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);
            $this->reset(['jumlah_bayar', 'keterangan']);
            $this->dispatch('close-modal');
            $this->fetchData($this->detailHutang['transaction_id']);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                }
                if ($response->getStatusCode() == 400) {
                    session()->flash('error_message', $body->message);
                    $this->reset(['jumlah_bayar', 'keterangan']);
                    $this->dispatch('close-modal');
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
        return view('livewire.app.hutang-piutang.hutang-details');
    }
}
