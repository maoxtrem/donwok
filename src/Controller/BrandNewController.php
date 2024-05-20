<?php

namespace App\Controller;

use App\Entity\DetallesFactura;
use App\Entity\Facturas;
use App\Repository\DetallesFacturaRepository;
use App\Repository\FacturasRepository;
use App\Repository\ProductoRepository;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BrandNewController extends AbstractController
{
    #[Route('/', name: 'app_menu')]
    public function index(): Response
    {

        return $this->render('brand_new/index.html.twig');
    }

    #[Route('/mesero', name: 'app_mesero')]
    public function mesero(
        ProductoRepository $productoRepository,
        FacturasRepository $facturasRepository
    ): Response
    {

        return $this->render('mesero/index.html.twig', ['productos' => $productoRepository->todosProductos(), 'num_factura' => $facturasRepository->facturaNumero()
        ]);
    }


    #[Route('/crear/pedido', name: 'app_crear_pedido')]
    public function app_crear_pedido(
        Request                   $request,
        FacturasRepository        $facturasRepository,
        ProductoRepository        $productoRepository,
        DetallesFacturaRepository $detallesFacturaRepository
    ): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $factura = $facturasRepository->findOneBy(['numero' => $parameters['id_factura']]);
        $producto = $productoRepository->find($parameters['id_producto']);

        if (!$factura instanceof Facturas) {
            $factura = new Facturas();
            $factura->setNombre($parameters['name_cliente']);
            $factura->setNumero($parameters['id_factura']);
            $factura->setEstado(0);
            $facturasRepository->guardar($factura);
        }
        if ($parameters['name_cliente'] == "") {
            $parameters['name_cliente'] = "sin nombre";
        }
        $factura->setNombre($parameters['name_cliente']);
        $detalleFactura = new DetallesFactura();
        $detalleFactura->setFactura($factura);
        $detalleFactura->setProducto($producto);
        $detalleFactura->setEstado(0);
        $detallesFacturaRepository->guardar($detalleFactura);
        $detalles = $detallesFacturaRepository->getAllDetallesByFactura($factura);
        return $this->json(['detalles' => $detalles]);
    }

    #[Route('/eliminar/pedido', name: 'app_eliminar_pedido')]
    public function app_eliminar_pedido(
        Request                   $request,
        FacturasRepository        $facturasRepository,
        DetallesFacturaRepository $detallesFacturaRepository
    ): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $factura = $facturasRepository->findOneBy(['numero' => $parameters['id_factura']]);
        $detalle = $detallesFacturaRepository->find((int)$parameters['id_detalle']);
        $detallesFacturaRepository->borrar($detalle);
        $detalles = $detallesFacturaRepository->getAllDetallesByFactura($factura);
        return $this->json(['detalles' => $detalles]);
    }



    #[Route('/cliente', name: 'app_cliente')]
    public function app_cliente(
        FacturasRepository        $facturasRepository,
        DetallesFacturaRepository $detallesFacturaRepository
    ): Response
    {
        $json = [];
        $facturas = $facturasRepository->findBy(['estado'=>0]);
        foreach ($facturas as $item) {
            $detalles = $detallesFacturaRepository->getAllDetallesByFactura($item);
            array_push($json,$detalles);

        }
        return $this->render('cliente/index.html.twig', ['facturas' => $json]);
    }
    #[Route('/cocinero', name: 'app_cocinero')]
    public function app_cocinero(
        FacturasRepository        $facturasRepository,
        DetallesFacturaRepository $detallesFacturaRepository
    ): Response
    {
        $json = [];
        $facturas = $facturasRepository->findBy(['estado'=>0]);
        foreach ($facturas as $item) {
            $detalles = $detallesFacturaRepository->getAllDetallesByFactura($item);
            array_push($json,$detalles);

        }
        return $this->render('cocinero/index.html.twig', ['facturas' => $json]);
    }

    #[Route('/entregar/pedido', name: 'app_entregar_pedido')]
    public function app_entregar_pedido(
        Request                   $request,
        DetallesFacturaRepository $detallesFacturaRepository
    ): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $detalle = $detallesFacturaRepository->find((int)$parameters['id_detalle']);
       if($detalle instanceof DetallesFactura){
           $detalle->setEstado(1);
           $detallesFacturaRepository->guardar($detalle);
       }
        return $this->json([]);
    }
    #[Route('/finalizar/pedido', name: 'app_finalizar_pedido')]
    public function app_finalizar_pedido(
        Request                   $request,
        FacturasRepository $facturasRepository
    ): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $parameters = json_decode($request->getContent(), true);
        $factura = $facturasRepository->find((int)$parameters['id_factura']);
        if($factura instanceof Facturas){
            $factura->setEstado(1);
            $facturasRepository->guardar($factura);
        }
        return $this->json([]);
    }
}
