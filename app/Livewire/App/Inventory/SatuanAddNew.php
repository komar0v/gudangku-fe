<?php

namespace App\Livewire\App\Inventory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class SatuanAddNew extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Register New Unit')]

    public $nama_satuan, $kode_satuan;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function rules()
    {
        return [
            'nama_satuan' => 'required',
            'kode_satuan' => 'required',
        ];
    }

    public function saveSatuan()
    {
        $this->validate();

        $data = [
            'nama_satuan' => $this->nama_satuan,
            'kode_satuan' => $this->kode_satuan
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/satuan-barang/add', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appInventoryIndexPage', navigate: true);
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
        return view('livewire.app.inventory.satuan-add-new');
    }
}
