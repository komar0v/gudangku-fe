<?php

namespace App\Livewire\App\Account;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Info extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Account Information')]
    public $accountData;
    public $fullname, $email, $nomer_wa, $role, $created_at;

    public function mount()
    {
        if (! $this->ensureAuthenticated()) {
            return; // redirect sudah dilakukan oleh Trait
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->get('/api/account/info', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->accountData = json_decode($res->getBody()->getContents(), true);
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

    public function rules()
    {
        return [
            'fullname' => 'required',
            'nomer_wa' => 'required|numeric',
            'email' => 'required|email',
        ];
    }

    public function render()
    {
        $this->mount();
        $this->fullname = $this->accountData['data']['fullname'];
        $this->email = $this->accountData['data']['email'];
        $this->role = $this->accountData['data']['role'];
        $this->nomer_wa = $this->accountData['data']['nomer_wa'];
        $this->created_at = IndoDateFormat::formatIndo($this->accountData['data']['created_at']);

        return view('livewire.app.account.info');
    }

    public function updateMyAccount()
    {
        $this->validate();

        $data = [
            'fullname' => $this->fullname,
            'nomer_wa' => $this->nomer_wa,
            'email' => $this->email,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->put('/api/account/update', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            $authData = session('auth_data');
            $authData['accountdata']['fullname'] = $data['fullname'];
            $authData['accountdata']['email'] = $data['email'];
            $authData['accountdata']['nomer_wa'] = $data['nomer_wa'];
            session(['auth_data' => $authData]);

            session()->flash('success_message', $responseData['message']);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 422) {

                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('accountInfoPage');
                    return;
                } else {
                    dd($body);
                }
            }
            throw $e;
        }
    }
}
