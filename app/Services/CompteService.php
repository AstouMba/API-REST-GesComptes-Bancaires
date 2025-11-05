<?php
namespace App\Services;
use App\Models\Compte;
use App\Models\Client;
use App\Models\User;
use App\Models\Transaction;
use App\Repository\CompteRepository;
use App\Events\CompteCreated;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DateTime;
class CompteService{
    private CompteRepository $compteRepository;
    public function __construct($compteRepository){
       $this->compteRepository=$compteRepository;
    }
    public function create($data):Compte{
        return DB::transaction(function () use ($data) {
            $client = null;
            if (isset($data['client_id'])) {
                $client = Client::find($data['client_id']);
            }
            if (!$client && isset($data['telephone'])) {
                $client = Client::where('telephone', $data['telephone'])->first();
            }
            if (!$client && isset($data['email'])) {
                $client = Client::where('email', $data['email'])->first();
            }
            if (!$client && isset($data['nci'])) {
                $client = Client::where('nci', $data['nci'])->first();
            }

            $password = null;
            $code = null;
            $user = null;

            if ($client) {
                if (!$client->utilisateur_id) {
                    $password = Str::random(10);
                    $code = rand(100000, 999999);
                    $login = $client->telephone ?? $client->email ?? 'user' . rand(1000, 9999);

                    $user = User::create([
                        'id' => Str::uuid(),
                        'login' => $login,
                        'password' => Hash::make($password),
                        'code' => $code,
                        'is_admin' => false,
                    ]);

                    $client->update(['utilisateur_id' => $user->id]);
                } else {
                    $user = $client->utilisateur;
                }
            } else {
                $password = Str::random(10);
                $code = rand(100000, 999999);
                $login = $data['telephone'] ?? $data['email'] ?? 'user' . rand(1000, 9999);

                $user = User::create([
                    'id' => Str::uuid(),
                    'login' => $login,
                    'password' => Hash::make($password),
                    'code' => $code,
                    'is_admin' => false,
                ]);

                $client = Client::create([
                    'id' => Str::uuid(),
                    'titulaire' => $data['titulaire'] ?? '',
                    'email' => $data['email'] ?? null,
                    'telephone' => $data['telephone'] ?? null,
                    'adresse' => $data['adresse'] ?? null,
                    'nci' => $data['nci'] ?? null,
                    'utilisateur_id' => $user->id,
                ]);
            }

            $compteData = [
                'client_id' => $client->id,
                'titulaire' => $client->titulaire,
                'type' => $data['type'] ?? 'cheque',
                'devise' => $data['devise'] ?? 'FCFA',
            ];

            $compte = $this->compteRepository->create($compteData);

            if (isset($data['soldeInitial']) && $data['soldeInitial'] > 0) {
                Transaction::create([
                    'id' => Str::uuid(),
                    'compte_id' => $compte->id,
                    'type' => 'depot',
                    'montant' => $data['soldeInitial'],
                    'description' => 'Solde initial',
                ]);
            }

            event(new CompteCreated($compte, $client, $password, $code));

            return $compte;
        });
    }

    public function all(){
    return $this->compteRepository->all();
    }
}
