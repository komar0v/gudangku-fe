<?php

namespace App\Livewire\App\Inventory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class SatuanDetail extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Unit Detail')]

    public $unitData;
    public $nama_satuan, $kode_satuan;

    public function mount($unitId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/satuan-barang/' . $unitId . '/detail', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->unitData = json_decode($res1->getBody()->getContents(), true);
            $this->nama_satuan = $this->unitData['nama_satuan'];
            $this->kode_satuan = $this->unitData['kode_satuan'];
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 403) {
                    //Forbidden
                    session()->flash('error_message', 'Forbidden.');
                    $this->redirectRoute('appDashboardPage');
                    return;
                } else if ($response->getStatusCode() == 404) {

                    session()->flash('error_message', 'Satuan tidak ditemukan.');
                    $this->redirectRoute('appInventoryIndexPage', navigate: true);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }

    public function rules()
    {
        return [
            'nama_satuan' => 'required',
            'kode_satuan' => 'required',
        ];
    }

    public function saveChanges()
    {
        $this->validate();

        $data = [
            'nama_satuan' => $this->nama_satuan,
            'kode_satuan' => $this->kode_satuan
        ];


        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->put('/api/super-admin/manage/satuan-barang/'.$this->unitData['id'].'/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);


            session()->flash('success_message', $responseData['message']);
            return;
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
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
        return view('livewire.app.inventory.satuan-detail');
    }
}
