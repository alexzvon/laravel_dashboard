<?php

namespace App\Http\Controllers\Api\Catalog;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Requests\Catalog\CreateNodeCatalogRequest;
use App\Http\Requests\Catalog\GetNodesCatalogRequest;
use App\Http\Resources\Catalog\NodeCatalogResource;
use App\Http\Resources\Catalog\NodesCatalogCollection;
use App\Repositories\Api\Catalog\CatalogRepository;
use Illuminate\Http\JsonResponse;

class CatalogController extends ApiBaseController
{
    private CatalogRepository $catalogRepository;

    public function __construct()
    {
        $this->catalogRepository = app(CatalogRepository::class);
    }
    /**
     * @param CreateNodeCatalogRequest $request
     * @return JsonResponse
     */
    public function createNodeCatalog(CreateNodeCatalogRequest $request): JsonResponse
    {
        return $this->returnJsonResponse($this->catalogRepository->createNodeCatalog($request));
    }
    /**
     * @param GetNodesCatalogRequest $request
     * @return JsonResponse|NodesCatalogCollection
     */
    public function getNodesCatalog(GetNodesCatalogRequest $request): JsonResponse|NodesCatalogCollection
    {
        $result = $this->catalogRepository->getNodesCatalog($request);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return NodesCatalogCollection::make($result);
        }
    }
    /**
     * @param int $id
     * @return JsonResponse|NodeCatalogResource
     */
    public function getNodeCatalog(int $id): JsonResponse | NodeCatalogResource
    {
        $result = $this->catalogRepository->getNodeCatalog($id);

        if (is_array($result)) {
            return response()->json($result, 422);
        } else {
            return NodeCatalogResource::make($result);
        }
    }
    /**
     * @param GetNodesCatalogRequest $request
     * @return JsonResponse
     */
    public function deleteNodeCatalog(GetNodesCatalogRequest $request): JsonResponse
    {
        return $this->returnJsonResponse($this->catalogRepository->deleteNodeCatalog($request));
    }
}
