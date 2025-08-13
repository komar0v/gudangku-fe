<?php

namespace App\Livewire\App\Inventory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class CategoryAddNew extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Register New Category')]

    public $nama_kategori;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }
    }

    public function rules()
    {
        return [
            'nama_kategori' => 'required',
        ];
    }

    public function saveCategory()
    {
        $this->validate();

        $data = [
            'nama_kategori' => $this->nama_kategori
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/category/add', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Kategori ' . $responseData['data']['nama_kategori'] . ' berhasil ditambahkan');

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
        return view('livewire.app.inventory.category-add-new');
    }
}
