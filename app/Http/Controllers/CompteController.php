<?php

namespace App\Http\Controllers;

use App\Enums\MessageEnumFr;
use App\Services\CompteService;
use Illuminate\Http\Request;
use App\Traits\ApiResponses;
use Symfony\Component\HttpFoundation\Response;
class CompteController extends Controller
{
    use ApiResponses;
    private CompteService $compteService;
    public function __construct($compteService)
    {
        $this->compteService = $compteService;
    }

    public function store(Request $request)
    {
        try {
            $comptes = $this->compteService->create($request->all());
            return $this->successResponse($comptes, MessageEnumFr::COMPTE_CREE, Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return $this->errorResponseWithData($request->all(), MessageEnumFr::ERREUR_CREATION_COMPTE, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function index()
    {
        try {
            $comptes = $this->compteService->all();
            return $this->successResponse($comptes, MessageEnumFr::LISTE_COMPTES_RECUPÉRÉE,Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->errorResponse(MessageEnumFr::ERREUR_RECUPERATION_LISTE_COMPTES, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}