<?php
declare(strict_types=1);

namespace App\Controller\Api\v1;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Entity\Product;

class ProductApiV1Controller extends AbstractController
{
    protected const REQUIRED_FIELDS = ['name', 'ean13'];
    protected const DEFAULT_HEADER = ['Content-Type: application/json'];
        
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
     )
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    
    
    public function getProducts(): JsonResponse
    {
        try {
            $response = self::getProductsForApi();
            return new JsonResponse($response, JsonResponse::HTTP_OK, self::DEFAULT_HEADER);
        } catch (\TypeError $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        } catch (\Exception $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }        
    }
    
    protected function castDataToArrayForApi(Product $product): array
    {
        $dataCategories = [];
        $categories = $this->categoryRepository->getCategoriesByProductId($product->getProductId());
        
        foreach ($categories as $category){
            $dataCategories[] = [
                'name' => $category->getName(),
                'description' => $category->getDescription(),
                'short_description' => $category->getShortDescription()
            ];
        }
        return [
            'id' => $product->getProductId(),
            'name' => $product->getName(),
            'ean13' => $product->getEan13(),
            'reference' => $product->getReference(),
            'qty' => $product->getQuantity(),
            'active' => $product->isIsActive(),
            'eliminate' => $product->isIsEliminate(),
            'date_add' => $product->getDateAdd()->format('d-m-Y H:i'),
            'categories' => $dataCategories
        ];
    }
    
    
    protected function getProductsForApi(): array
    {
        $dataProducts = [];
        $limit = (int)$_REQUEST['limit'] ?? 3;
        $offset = (int)$_REQUEST['offset'] ?? 0;
        /*
         * Mostrar todos los registros de la tabla sin paginación
         * 
        $products = $this->productRepository->findAll();
        foreach ($products as $product){
            $dataProducts[] = self::castDataToArrayForApi($product);
        }
        */
        /***** Mostrar los resultados con paginación********/
        $products = $this->productRepository->findProductsByPagination($limit, $offset);
        $dataProducts['total_items'] = $products['paginator']->count();
        $dataProducts['total_pages'] = ceil($products['paginator']->count() / $limit);
        $dataProducts['current_page'] = $offset + 1;
        $dataProducts['total_items_by_page'] = $limit;
        $dataProducts['data'] = [];
        foreach ($products['products'] as $product){
            $dataProducts['data'][] = self::castDataToArrayForApi($product);
        }
        /******************************************/
        return $dataProducts;
    }
    
    protected function validateRequiredFieldsForAddProduct(array $data): bool
    {
        foreach (self::REQUIRED_FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                return false;
            }
        }
        return true;
    }
    
    protected function saveDataProduct(Object $data): Product
    {
        $newProduct = new Product();
        $newProduct->setName($data->name);
        $newProduct->setEan13($data->ean13);
        isset($data->reference) && $newProduct->setReference($data->reference);
        isset($data->qty) && $newProduct->setQuantity($data->qty);
        isset($data->active) && $newProduct->setIsActive($data->active);
        isset($data->eliminate) && $newProduct->setIsEliminate($data->eliminate);
        $this->productRepository->save($newProduct);
        return $newProduct;
    }
    
    public function addProduct(Request $request): JsonResponse
    {
        try {
            $dataRequest = json_decode($request->getContent());
            if(!self::validateRequiredFieldsForAddProduct((array)$dataRequest)){
                return new JsonResponse([
                        'msg' => 'Faltan datos que son obligatorios para crear el producto.',
                        'required_fields' => self::REQUIRED_FIELDS
                    ], JsonResponse::HTTP_BAD_REQUEST
                );
            }
            $newProduct = self::saveDataProduct($dataRequest);
            if(!$newProduct->getProductId()){
                throw new \Exception('No fue posible crear el producto. Intente de nuevo o contacte con el área de soporte.');
            }
            $response = [
                'msg' => 'Producto creado correctamente.',
                'data' => self::castDataToArrayForApi($newProduct)
            ];
            return new JsonResponse($response, JsonResponse::HTTP_CREATED, self::DEFAULT_HEADER);
        } catch (\TypeError $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        } catch (\Exception $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    public function deleteProduct(int $product_id): JsonResponse
    {
        try {
            $product = $this->productRepository->findById($product_id);
            if(!$product){
                return new JsonResponse([
                    'msg' => 'Producto no encontrado.',
                    ], JsonResponse::HTTP_NOT_FOUND
                );
            }
            
            /* Eliminacion del registro totalmente de la base de datos
            $this->productRepository->remove($product);
            if($product->getProductId()){
                throw new \Exception('No fue posible eliminar el producto. Intente de nuevo o contacte con el área de soporte.');
            }
            */
            
            /* Borrado logico del registro */
            $product->setIsActive(false);
            $product->setIsEliminate(true);
            $product->setDateUpd(new \DateTime());
            $this->productRepository->save($product);
            if(!$product->isIsEliminate()){
                throw new \Exception('No fue posible eliminar el producto. Intente de nuevo o contacte con el área de soporte.');
            }
            /****************/
            return new JsonResponse(['msg' => 'Producto eliminado correctamente.'], JsonResponse::HTTP_OK, self::DEFAULT_HEADER);
        } catch (\TypeError $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_SERVICE_UNAVAILABLE);
        } catch (\Exception $e) {
            return new JsonResponse(['msg' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    
  
}