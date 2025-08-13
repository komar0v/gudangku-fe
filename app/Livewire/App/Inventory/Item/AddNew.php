<?php

namespace App\Livewire\App\Inventory\Item;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class AddNew extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Show All Items')]

    public $itemData;
    public $nama_barang, $kategori_id, $satuan_id;
    public $categoryList, $satuanList;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res2 = $client->get('/api/super-admin/manage/get-all-categories', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->categoryList = json_decode($res2->getBody()->getContents(), true)['data'];

            $res3 = $client->get('/api/super-admin/manage/get-all-satuan-barang', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->satuanList = json_decode($res3->getBody()->getContents(), true)['data'];
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

                    session()->flash('error_message', 'Barang tidak ditemukan.');
                    $this->redirectRoute('appInventoryIndexPage', navigate: true);
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }

    }

    public function rules(){
        return [
            'nama_barang' => 'required',
            'kategori_id' => 'required',
            'satuan_id' => 'required',
        ];
    }

    public function saveNewItem(){
        $this->validate();

        $data=[
            'nama_barang'=>$this->nama_barang,
            'kategori_id'=>$this->kategori_id,
            'satuan_id'=>$this->satuan_id,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/inventory/item/add', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);
            $this->redirectRoute('appShowAllItemsPage', navigate: true);
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
        return view('livewire.app.inventory.item.add-new');
    }
}
