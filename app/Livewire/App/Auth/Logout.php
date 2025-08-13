<?php

namespace App\Livewire\App\Auth;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Logout extends Component
{
    use RequireLogin;
    #[Layout('components.layouts.applayout')]
    #[Title('Logging Out')]

    public function mount()
    {
        $this->ensureAuthenticated();

        try {
            $apiURL = env('API_URL');
            $client = new Client([
                'base_uri' => $apiURL,
            ]);

            $res = $client->post('/api/auth/logout', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            session()->forget('auth_data');
            session()->flush();
            session()->invalidate();
        } catch (RequestException $e) {

            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $body = json_decode($response->getBody()->getContents());

                if ($response->getStatusCode() == 401) {
                    //UNAUTHORIZED
                    $this->redirectRoute('appLoginPage');
                } else {
                    dd($body);
                }
            } else {
                dd($e->getMessage());
            }
        }
    }

    public function render()
    {
        session()->forget('auth_data');
        session()->flush();
        session()->invalidate();
        return view('livewire.app.auth.logout');
    }
}
