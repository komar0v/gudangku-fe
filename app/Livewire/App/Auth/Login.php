<?php

namespace App\Livewire\App\Auth;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use GuzzleHttp\Exception\RequestException;

class Login extends Component
{
    #[Layout('components.layouts.applayout')]
    #[Title('Login App')]
    public $email, $password;

    public function render()
    {
        if (session('auth_data')) {
            $this->redirectRoute('appDashboardPage');
        }
        return view('livewire.app.auth.login');
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function loginUser()
    {
        $this->validate();

        $data = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        // dd($data);
        $apiURL = env('API_URL');
        $client = new Client([
            'base_uri' => $apiURL,
        ]);

        try {
            $res1 = $client->post('/api/auth/login', [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'json' => $data
            ]);

            $getToken = json_decode($res1->getBody()->getContents(), true);

            $res2 = $client->get('/api/account/info', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $getToken['token']
                ],
            ]);

            $accountInfo = json_decode($res2->getBody()->getContents(), true);

            $authData = [
                'token' => $getToken['token'],
                'accountdata' => $accountInfo['data'],
            ];

            session(['auth_data' => $authData]);
            $this->redirectRoute('appDashboardPage');

        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());
                if ($response->getStatusCode() == 422) {
                    //UNAUTHORIZED
                    session()->flash('error_message', $body->message);
                    // $this->redirectRoute('loginPage');
                } else {
                    dd($body);
                }
            } else {
                dd($e->getMessage());
            }
        }
    }
}
