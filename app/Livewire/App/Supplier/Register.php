<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Register extends Component
{
    use RequireLogin;

    #[Layout('components.layouts.applayout')]
    #[Title('Register New Supplier')]

    public $nama_supplier, $negara = 'ID', $nomer_telepon_kantor, $email_kantor, $alamat, $website = 'https://www.example.com', $npwp = '00.0000.000000.811', $tentang, $user_id, $kategori_supplier;
    public $userList, $kategoriSupplierList;

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

            $this->kategoriSupplierList = json_decode($res1->getBody()->getContents(), true);

            $res2 = $client->get('/api/super-admin/manage/get-users-not-assigned', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->userList = json_decode($res2->getBody()->getContents(), true);
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
        return view('livewire.app.supplier.register');
    }

    public function rules()
    {
        return [
            'nama_supplier' => 'required',
            'nomer_telepon_kantor' => 'required|regex:/^\+?[0-9\s\-]{7,20}$/',
            'email_kantor' => 'required|email',
            'tentang' => 'required',
            'user_id' => 'required',
            'kategori_supplier' => 'required',
        ];
    }

    public function saveSupplierData()
    {
        $this->validate();

        $data = [
            'user_id' => $this->user_id,
            'nama_supplier' => $this->nama_supplier,
            'kategori_supplier' => $this->kategori_supplier,
            'negara' => $this->negara,
            'nomer_telepon_kantor' => $this->nomer_telepon_kantor,
            'email_kantor' => $this->email_kantor,
            'website' => $this->website,
            'npwp' => $this->npwp,
            'alamat' => $this->alamat,
            'tentang' => $this->tentang,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/supplier/add', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', $responseData['data']['nama_supplier'] . ' berhasil ditambahkan');

            $this->redirectRoute('appSupplierIndexPage', navigate: true);
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
