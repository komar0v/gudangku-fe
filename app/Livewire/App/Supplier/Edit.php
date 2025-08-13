<?php

namespace App\Livewire\App\Supplier;

use GuzzleHttp\Client;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Helpers\IndoDateFormat;
use Livewire\Attributes\Layout;
use App\Livewire\Traits\RequireLogin;
use GuzzleHttp\Exception\RequestException;

class Edit extends Component
{
    use RequireLogin, WithFileUploads;

    #[Layout('components.layouts.applayout')]
    #[Title('Edit Data Supplier')]

    public $supplierData;
    public $logo_img, $created_at;
    public $logo_file;
    public $nama_supplier, $kategori_supplier, $negara, $email_kantor, $website, $npwp, $alamat, $tentang, $user_id, $nomer_telepon_kantor;
    public $userList, $kategoriSupplierList;

    public function mount($supplierId)
    {
        if (! $this->ensureAuthenticated()) {
            return;
        }

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res1 = $client->get('/api/super-admin/manage/supplier/details/' . $supplierId, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->supplierData = json_decode($res1->getBody()->getContents(), true);

            $res2 = $client->get('/api/super-admin/manage/get-all-categories', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->kategoriSupplierList = json_decode($res2->getBody()->getContents(), true);

            $res3 = $client->get('/api/super-admin/manage/supplier/assignable-users/' . $this->supplierData['user_id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
            ]);

            $this->userList = json_decode($res3->getBody()->getContents(), true);

            $this->logo_img = env('API_URL') . '/' . $this->supplierData['logo_file_path'];
            $this->created_at = IndoDateFormat::formatIndo($this->supplierData['created_at']);

            $this->nama_supplier = $this->supplierData['nama_supplier'];
            $this->kategori_supplier = $this->supplierData['kategori_supplier'];
            $this->negara = $this->supplierData['negara'];
            $this->email_kantor = $this->supplierData['email_kantor'];
            $this->nomer_telepon_kantor = $this->supplierData['nomer_telepon_kantor'];
            $this->website = $this->supplierData['website'];
            $this->npwp = $this->supplierData['npwp'];
            $this->user_id = $this->supplierData['user_id'];
            $this->tentang = $this->supplierData['tentang'];
            $this->alamat = $this->supplierData['alamat'];
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
                    //Forbidden
                    session()->flash('error_message', $body->message);
                    $this->redirectRoute('appSupplierIndexPage', navigate: true);
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
        return view('livewire.app.supplier.edit');
    }

    public function saveSupplierData1()
    {
        $this->validate([
            'negara' => 'required',
            'nomer_telepon_kantor' => 'required|regex:/^\+?[0-9\s\-]{7,20}$/',
            'email_kantor' => 'required|email',
            'website' => 'required',
            'npwp' => 'required',
            'alamat' => 'required',
            'tentang' => 'required',
        ]);

        $data = [
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

            $res = $client->post('/api/super-admin/manage/supplier/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Perubahan data supplier ' . $responseData['data']['nama_supplier'] . ' berhasil disimpan');
            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']], navigate: true);
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

    public function saveSupplierData2(){
        $this->validate([
            'nama_supplier'=>'required',
            'kategori_supplier'=>'required',
            'user_id'=>'required'
        ]);

        $data=[
            'nama_supplier'=>$this->nama_supplier,
            'kategori_supplier'=>$this->kategori_supplier,
            'user_id'=>$this->user_id,
        ];

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/supplier/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'json' => $data
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);

            session()->flash('success_message', 'Perubahan data supplier ' . $responseData['data']['nama_supplier'] . ' berhasil disimpan');
            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']], navigate: true);
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

    public function changeLogo()
    {
        $file = $this->logo_file;

        $this->validate([
            'logo_file' => 'required|image|max:1024',
        ]);


        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();

        try {
            $client = new Client(['base_uri' => env('API_URL')]);

            $res = $client->post('/api/super-admin/manage/supplier/update/' . $this->supplierData['id'], [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . session('auth_data.token')
                ],
                'multipart' => [
                    [
                        'name'     => 'logo_file',
                        'filename' => $fileName,
                        'Mime-Type' => $file->getMimeType(),
                        'contents' => fopen($filePath, 'r'),
                    ]
                ]
            ]);

            $responseData = json_decode($res->getBody()->getContents(), true);
            session()->flash('success_message', $responseData['message']);

            $this->redirectRoute('appSupplierDetailPage', ['supplierId' => $this->supplierData['id']], navigate: true);
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
