<?php

namespace App\Livewire\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;

trait RequireLogin
{
    public function ensureAuthenticated(): bool
    {
        if (!session()->has('auth_data.token')) {
            session()->flash('error_message', 'Silakan login terlebih dahulu.');
            $this->redirectRoute('appLoginPage');
            return false;
        }

        $token = session('auth_data.token');

        $client = new Client([
            'base_uri' => env('API_URL'),
        ]);

        try {
            $client->get('/api/account/info', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]);

            return true;

        } catch (ClientException $e) {
            if ($e->getResponse()->getStatusCode() === 401) {
                // Token tidak valid/expired
                session()->forget('auth_data');
                session()->flash('error_message', 'Silakan login kembali.');
                $this->redirectRoute('appLoginPage');
                return false;
            }

            throw $e;
        } catch (RequestException $e) {
            throw $e;
        }
    }
}
