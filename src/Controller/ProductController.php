<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/api/")
 */
class ProductController extends AbstractController
{
    const AUTHTOKEN = 'Bearer admintoken';
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @var Serializer
     */
    private $serializer;

    public function __construct(ProductRepository $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;

        $encoders = [ new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);

    }

    /**
     * @Route("products", name="get_all_products", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function getAll(Request $request): Response
    {
        $name = $request->query->get('name','');
        $page = $request->query->get('page',1);
        $limit = $request->query->get('maxResults',10);

        $criteria = !empty($name) ? ['name'=> $name ]: [];
        $products = $this->productRepository->findBy(
            $criteria,
            null,
            $limit,
            ($page -1) * $limit
        );

        $jsonContent = $this->serializer->serialize($products, 'json');
        return new JsonResponse( json_decode($jsonContent), Response::HTTP_OK);
    }

    /**
     * @Route("product", name="add_product", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function add( Request $request): Response
    {
        $data = json_decode($request->getContent(), true);
        $authorised = $request->headers->get('Authorization') === self::AUTHTOKEN;
        if(!$authorised){
            return new JsonResponse(['status'=>'Unauthorized user!'], Response::HTTP_UNAUTHORIZED);
        }
        try{
            $this->productService->new($data);
        }
        catch (\InvalidArgumentException | NotFoundHttpException $exception)
        {
            return new JsonResponse(['status'=>$exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['status'=>'Product created!'], Response::HTTP_OK);
    }
}
