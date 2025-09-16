<?php

namespace App\Livewire\App\Cashflow\CashflowCategory;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class AddCategory extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Manage Cashflow Categories')]

    public $name, $description;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return;
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

            $res = $client->post('/api/super-admin/manage/cashflow/category/create', [
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
        return view('livewire.app.cashflow.cashflow-category.add-category');
    }
}
