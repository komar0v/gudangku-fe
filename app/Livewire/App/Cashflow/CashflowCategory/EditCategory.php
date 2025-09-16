<?php

namespace App\Livewire\App\Cashflow\CashflowCategory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class EditCategory extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Edit Cashflow Categories')]

    public $cashflwCatId;
    public $name, $description;

    public function mount($cashflowCatId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/cashflow/category/'.$cashflowCatId.'/details', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ]
            ]);

            $responseData = json_decode($res1->getBody()->getContents(), true)['data'];

            $this->cashflwCatId = $responseData['id'];
            $this->name = $responseData['name'];
            $this->description = $responseData['description'];
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

    public function rules()
    {
        return [
            'name' => 'required',
            'description' => 'required',
        ];
    }

    public function saveData()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->put('/api/super-admin/manage/cashflow/category/'.$this->cashflwCatId.'/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appManageCashflowCategoryPage', navigate: true);
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
        return view('livewire.app.cashflow.cashflow-category.edit-category');
    }
}
