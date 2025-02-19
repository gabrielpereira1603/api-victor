<?php

namespace App\Http\Controllers\Api\Blocks;

use App\Exceptions\Api\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Blocks\CreateBlocksRequest;
use App\Models\Blocks;
use App\Services\Blocks\BlocksService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BlocksController extends Controller
{
    private BlocksService $blocksService;

    public function __construct(BlocksService $blocksService)
    {
        $this->blocksService = $blocksService;
    }

    public function create(CreateBlocksRequest $request): JsonResponse
    {
        try{
            $data = $request->validated();

            $blocks = $this->blocksService->createBlock($data);

            return response()->json([
                'error' => false,
                'message' => 'Compromisso criado com sucesso.',
                'data' => $blocks
            ], 201);
        } catch (\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'Erro ao criar Compromisso.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


}
