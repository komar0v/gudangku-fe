<?php

namespace App\Livewire\App\Inventory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Index extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Inventory Master Data')]

    public $categoryList, $satuanBarangList;
    public $itemCount, $lowStokItemCount;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/get-all-categories', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->categoryList = json_decode($res1->getBody()->getContents(), true)['data'];

            $res2 = $client->get('/api/super-admin/manage/get-all-satuan-barang', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->satuanBarangList = json_decode($res2->getBody()->getContents(), true)['data'];

            $res3 = $client->get('/api/super-admin/manage/inventory/count/all', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->itemCount = json_decode($res3->getBody()->getContents(), true)['total_items'];

            $res4 = $client->get('/api/super-admin/manage/inventory/item/get-hampir-habis', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->lowStokItemCount = count(json_decode($res4->getBody()->getContents(), true));
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
        return view('livewire.app.inventory.index');
    }
}
