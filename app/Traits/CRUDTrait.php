<?php

namespace App\Traits;

trait CRUDTrait
{
    public function findAll()
    {
        try {
            $models = $this->model::withTrashed()
                ->with(['neighborhood', 'city', 'state'])
                ->get();

            return response()->json([
                'success' => true,
                'data' => $models,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao recuperar os dados.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function findOne($id)
    {
        try {
            $model = $this->model::withTrashed()
                ->with(['neighborhood', 'city', 'state'])
                ->find($id);

            if (!$model) {
                return response()->json([
                    'success' => false,
                    'message' => 'Registro não encontrado.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $model,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao recuperar o registro.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function create(Request $request)
    {
        // Você pode adicionar validações aqui se necessário
        try {
            $model = $this->model::create($request->all()); // Criação do modelo
            return response()->json([
                'success' => true,
                'message' => 'Registro criado com sucesso.',
                'data' => $model,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao criar o registro.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $model = $this->model::find($id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Registro não encontrado.',
            ], 404);
        }

        // Você pode adicionar validações aqui se necessário
        try {
            $model->update($request->all()); // Atualização do modelo
            return response()->json([
                'success' => true,
                'message' => 'Registro atualizado com sucesso.',
                'data' => $model,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao atualizar o registro.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function delete($id)
    {
        $model = $this->model::find($id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Registro não encontrado.',
            ], 404);
        }

        $model->delete(); // Soft delete
        return response()->json([
            'success' => true,
            'message' => 'Registro desativado com sucesso.',
        ], 200);
    }

    public function restore($id)
    {
        $model = $this->model::withTrashed()->find($id);
        if (!$model) {
            return response()->json([
                'success' => false,
                'message' => 'Registro não encontrado.',
            ], 404);
        }

        $model->restore(); // Restauração do soft delete
        return response()->json([
            'success' => true,
            'message' => 'Registro restaurado com sucesso.',
        ], 200);
    }
}
