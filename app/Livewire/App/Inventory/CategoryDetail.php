<?php

namespace App\Livewire\App\Inventory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class CategoryDetail extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Category Detail')]

    public $categoryData;
    public $nama_kategori, $categoryId, $created_at, $updated_at;

    public function mount($categoryId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        $this->categoryId = $categoryId;

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/category/details/' . $categoryId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->categoryData = json_decode($res1->getBody()->getContents(), true)['data'];
            $this->nama_kategori = $this->categoryData['nama_kategori'];

            $this->created_at = IndoDateFormat::formatIndo($this->categoryData['created_at']);
            $this->updated_at = IndoDateFormat::formatIndo($this->categoryData['updated_at']);
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

                    session()->flash('error_message', 'Kategori tidak ditemukan.');
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
            'nama_kategori' => 'required',
        ];
    }

    public function saveChanges()
    {
        $this->validate();

        $data = [
            'nama_kategori' => $this->nama_kategori
        ];


        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->put('/api/super-admin/manage/category/update/' . $this->categoryId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            session()->flash('success_message', 'Perubahan kategori berhasil disimpan');
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
        return view('livewire.app.inventory.category-detail');
    }
}
