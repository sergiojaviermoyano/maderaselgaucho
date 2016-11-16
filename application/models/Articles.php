<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Articles extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Articles_List(){

		$query= $this->db->get('articulos');
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{	
			return false;
		}
	}
	
	
	function getArticle($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idArt = $data['id'];

			$data = array();

			//Datos del articulo
			$query= $this->db->get_where('articulos',array('artId'=>$idArt));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['article'] = $c[0];

			} else {
				$art = array();

				$art['artId'] = '';
				$art['artDescripcion'] = '';
				$art['madId'] = '';
				$art['artOtrosCostos'] = '';
				$art['artOtrosCostosEsPorcentaje'] = '';
				$art['artMargen'] = '';
				$art['artMargenEsPorcentaje'] = '';
				$art['artMinimo'] = '';
				$art['artMaximo'] = '';
				$art['artPuntoPedido'] = '';
				$art['artEstado'] = 'AC';
				$art['artPrecio'] = '';
				$art['artlargo'] = '';
				$art['artAlto'] = '';
				$art['artEspesor'] = '';
				$art['artEsSimple'] = true;
				$art['artTipoMaterial'] = 'M';
				$art['artSeVendePorPie'] = false;
				$art['artOperativo'] = '';
				$art['artOperativoEsPorcentaje'] = '';
				$art['artEstructura'] = '';
				$art['artEstructuraEsPorcentaje'] = '';
				$art['artFlete'] = '';
				$art['artFleteEsPorcentaje'] = '';
				$art['artServicio'] = '';
				$art['artServicioEsPorcentaje'] = '';
				$art['ivaId'] = '';

				$data['article'] = $art;
			}
			$data['article']['action'] = $action;

			//Articulos extras
			$data['article']['detail'] = array();
			$this->db->select('articulosdetalle.artId_, articulos.artDescripcion, articulosdetalle.artDetCantidad, articulos.madId, articulos.artPrecio, articulos.artlargo, articulos.artEspesor, articulos.artAlto, articulos.artSeVendePorPie');
			$this->db->from('articulosdetalle');
			$this->db->join('articulos', 'articulos.artId = articulosdetalle.artId_');
			$this->db->where(array('articulosdetalle.artId' => $data['article']['artId']));
			$query = $this->db->get();
			if ($query->num_rows()!=0)
			{
				$detalle = $query->result_array();
				foreach ($detalle as $item) {
					if($item['madId'] != null){
						//Calcular precio con el valor de la madera
						
						$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
						if ($query->num_rows() != 0)
						{
							$m = $query->result_array();
							$madera = $m[0];
						}

						$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
						$cantPul = $cantPie * 3.77;

						$precio = 0;
						if($item['artSeVendePorPie'] == true){
							//Se vende por pie
							$precio = $cantPie * $madera['madPrecio'];
						} else {
							//Se vende por pulgada
							$precio = $cantPul * $madera['madPrecioPulgada'];
						}

						$item['artPrecio'] = $precio;
					}

					$data['article']['detail'][] = $item;
				}
			}


			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;

			//Maderas
			$query= $this->db->get_where('maderas',array('madEstado'=>'AC'));
			if ($query->num_rows() != 0)
			{
				$data['woods'] = $query->result_array();	
			}

			//Ivas
			$query= $this->db->get_where('ivas',array('ivaEstado'=>'AC'));
			if ($query->num_rows() != 0)
			{
				$data['ivas'] = $query->result_array();	
			}

			if($data['article']['artTipoMaterial'] == 'M'){
				if($data['article']['madId'] != ''){
					//Precio por pie
					//Precio por pulgada
					//Cantidad de pies
					//Cantidad de pulgadas
					//Buscar la madera seleccionada
					foreach ($data['woods'] as $madera) {
						if($madera['madId'] == $data['article']['madId']) {
							$data['article']['p_x_pie'] = $madera['madPrecio'];
							$data['article']['p_x_pul'] = $madera['madPrecioPulgada'];
							$data['article']['c_pie'] = '0.00';//Cantidad de pies
							$data['article']['c_pul'] = '0.00';//Cantidad de pulgadas
							break;
						}
					}
				} else {
					$data['article']['p_x_pie'] = $data['woods'][0]['madPrecio'];//Precio por pie
					$data['article']['p_x_pul'] = $data['woods'][0]['madPrecioPulgada'];//Precio por pulgada
					$data['article']['c_pie'] = '0.00';//Cantidad de pies
					$data['article']['c_pul'] = '0.00';//Cantidad de pulgadas
				}
			} else {
				$data['article']['p_x_pie'] = '0.00';//Precio por pie
				$data['article']['p_x_pul'] = '0.00';//Precio por pulgada
				$data['article']['c_pie'] = '0.00';//Cantidad de pies
				$data['article']['c_pul'] = '0.00';//Cantidad de pulgadas
			}
			
			return $data;
		}
	}
	
	function setArticle($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
            $act = $data['act'];
            $name = $data['name'];
            $price = $data['price'];
            $margin = $data['marg'];
            $marginP = $data['margP'];
            $status = $data['status'];
            $mat = $data['mat'];
            $esPie = $data['esPie'];
            $esSimple = $data['esSimple'];
            $oper 	= $data['oper'];
            $operP 	= $data['operP'];
            $estr 	= $data['estr'];
            $estrP 	= $data['estrP'];
            $flete	= $data['flete'];
            $fleteP	= $data['fleteP'];
            $serv	= $data['serv'];
            $servP	= $data['servP'];
            $otrG	= $data['otrG'];
            $otrGP	= $data['otrGP'];
            $min 	= $data['min'];
            $max 	= $data['max'];
            $pdp	= $data['pdp'];
            $espesor= $data['espesor'];
            $ancho	= $data['ancho'];
            $largo	= $data['largo'];
            $madId  = $data['madId'];
            $det 	= (isset($data['det']) ? $data['det'] : array());
            $ivaId	= $data['ivaId'];

			$data = array(
				   'artDescripcion' 				=> $name,
				   'artMargen' 						=> $margin,
				   'artMargenEsPorcentaje' 			=> ($marginP === 'true'),
				   'artEstado' 						=> $status,
				   'artPrecio' 						=> $price,
				   'artEsSimple'		 			=> $esSimple == 'S' ? true : false,
				   'artTipoMaterial' 				=> $mat,
				   'artSeVendePorPie' 				=> $mat == 'M' ? $esPie : false,
				   'artOtrosCostos'					=> $otrG,
				   'artOtrosCostosEsPorcentaje'		=> ($otrGP === 'true'),
				   'artOperativo'					=> $oper,
				   'artOperativoEsPorcentaje'		=> ($operP === 'true'),
				   'artEstructura'					=> $estr,
				   'artEstructuraEsPorcentaje'		=> ($estrP === 'true'),
				   'artFlete'						=> $flete,
				   'artFleteEsPorcentaje'			=> ($fleteP === 'true'),
				   'artServicio'					=> $serv,
				   'artServicioEsPorcentaje'		=> ($servP === 'true'),
				   'artMinimo'						=> $min, 
				   'artMaximo'						=> $max,
				   'artPuntoPedido'					=> $pdp,
				   'artEspesor'						=> $espesor == '' ? null : $espesor,
				   'artAlto'						=> $ancho == '' ? null : $ancho,
				   'artlargo'						=> $largo == '' ? null : $largo,
				   'madId'							=> $mat == 'M' ? $madId : null,
				   'ivaId'							=> $ivaId
				);

			switch($act){
				case 'Add':
					//Agregar Artículo 
					if($this->db->insert('articulos', $data) == false) {
						return false;
					} else {
						$id = $this->db->insert_id();

						foreach ($det as $item) {
							$detail = array(
								'artId'				=> $id,
								'artId_'			=> $item[0],
								'artDetCantidad' 	=> $item[1]
								);
							if($this->db->insert('articulosdetalle', $detail) == false) {
								return false;
							} 
						}
					}
					break;
				
				 case 'Edit':
				 	//Actualizar Artículo
				 	if($this->db->update('articulos', $data, array('artId'=>$id)) == false) {
				 		return false;
				 	} else {
				 		if($this->db->delete('articulosdetalle', array('artId'=>$id)) == false) {
					 		return false;
					 	} else {
					 		foreach ($det as $item) {
								$detail = array(
									'artId'				=> $id,
									'artId_'			=> $item[0],
									'artDetCantidad' 	=> $item[1]
									);
								if($this->db->insert('articulosdetalle', $detail) == false) {
									return false;
								} 
							}
						}
				 	}
				 	break;
					
				 case 'Del':
				 	//Eliminar Artículo
				 	if($this->db->delete('articulosdetalle', array('artId'=>$id)) == false) {
				 		return false;
				 	} else {
					 	if($this->db->delete('articulos', array('artId'=>$id)) == false) {
					 		return false;
					 	}
					 }
				 	break;
				 	
			}
			return true;

		}
	}
	
	function getArticleSingles($data = null){
		$str = '';
		if($data != null){
			$str = $data['str'];
		}

		$articles = array();

		$this->db->select('artId, artDescripcion, artPrecio, madId, artSeVendePorPie, artlargo, artAlto, artEspesor');
		$this->db->from('articulos');
		$this->db->like('artDescripcion', $str, 'both'); 
		$this->db->where(array('artEsSimple' => 1, 'artEstado'=>'AC'));
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			foreach ($query->result_array() as $item) {
				if($item['madId'] != null){
					//Calcular precio con el valor de la madera
					
					$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
					if ($query->num_rows() != 0)
					{
						$m = $query->result_array();
						$madera = $m[0];
					}

					$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
					$cantPul = $cantPie * 3.77;

					$precio = 0;
					if($item['artSeVendePorPie'] == true){
						//Se vende por pie
						$precio = $cantPie * $madera['madPrecio'];
					} else {
						//Se vende por pulgada
						$precio = $cantPul * $madera['madPrecioPulgada'];
					}

					$item['artPrecio'] = $precio;
				} 
				$articles[] = $item;
			}
			return $articles;
		}

		return array();
	}

	function searchByCode($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artId'=>$str, 'artEstado'=>'AC', 'artEsSimple' => 1)); 
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			if($query->num_rows() != 1){
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				foreach ($query->result_array() as $item) {
					if($item['madId'] != null){
						//Calcular precio con el valor de la madera
						
						$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
						if ($query->num_rows() != 0)
						{
							$m = $query->result_array();
							$madera = $m[0];
						}

						$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
						$cantPul = $cantPie * 3.77;

						$precio = 0;
						if($item['artSeVendePorPie'] == true){
							//Se vende por pie
							$precio = $cantPie * $madera['madPrecio'];
						} else {
							//Se vende por pulgada
							$precio = $cantPul * $madera['madPrecioPulgada'];
						}

						$item['artPrecio'] = $precio;
					} 
					$articles = $item;
				}

			}
			return $articles;
		}

		return $articles;
	}

	function searchByCodeAll($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artId'=>$str, 'artEstado'=>'AC')); 
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			if($query->num_rows() != 1){
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				foreach ($query->result_array() as $item) {
					if($item['madId'] != null){
						//Calcular precio con el valor de la madera
						
						$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
						if ($query->num_rows() != 0)
						{
							$m = $query->result_array();
							$madera = $m[0];
						}

						$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
						$cantPul = $cantPie * 3.77;

						$precio = 0;
						if($item['artSeVendePorPie'] == true){
							//Se vende por pie
							$precio = $cantPie * $madera['madPrecio'];
						} else {
							//Se vende por pulgada
							$precio = $cantPul * $madera['madPrecioPulgada'];
						}

						$item['artPrecio'] = $precio;
					} 
					$articles = $item;
				}

			}
			return $articles;
		}

		return $articles;
	}
	
	function searchByCodeAllWidthPrice($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$articles = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artId'=>$str, 'artEstado'=>'AC')); 
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			if($query->num_rows() != 1){
				//Multiples coincidencias
			} else {
				//Unica coincidencia
				foreach ($query->result_array() as $item) {
					if($item['artEsSimple'] == 1){
						if($item['madId'] != null){
							//Calcular precio con el valor de la madera
							
							$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
							if ($query->num_rows() != 0)
							{
								$m = $query->result_array();
								$madera = $m[0];
							}

							$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
							$cantPul = $cantPie * 3.77;

							$precio = 0;
							if($item['artSeVendePorPie'] == true){
								//Se vende por pie
								$precio = $cantPie * $madera['madPrecio'];
							} else {
								//Se vende por pulgada
								$precio = $cantPul * $madera['madPrecioPulgada'];
							}

							$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $precio);
						} else {
							$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $item['artPrecio']);
						} 
					} else {
						$acumulado = 0;
						$this->db->select('articulosdetalle.artId_, articulos.artDescripcion, articulosdetalle.artDetCantidad, articulos.madId, articulos.artPrecio, articulos.artlargo, articulos.artEspesor, articulos.artAlto, articulos.artSeVendePorPie');
						$this->db->from('articulosdetalle');
						$this->db->join('articulos', 'articulos.artId = articulosdetalle.artId_');
						$this->db->where(array('articulosdetalle.artId' => $item['artId']));
						$query2 = $this->db->get();
						if ($query2->num_rows()!=0)
						{
							$detalle = $query2->result_array();
							foreach ($detalle as $item_) {
								if($item_['madId'] != null){
									//Calcular precio con el valor de la madera
									
									$query3= $this->db->get_where('maderas',array('madId' => $item_['madId']));
									if ($query3->num_rows() != 0)
									{
										$m = $query3->result_array();
										$madera = $m[0];
									}

									$cantPie = ($item_['artlargo'] * $item_['artAlto'] * $item_['artEspesor'] * 4.24) / 10000000;
									$cantPul = $cantPie * 3.77;

									$precio = 0;
									if($item_['artSeVendePorPie'] == true){
										//Se vende por pie
										$precio = $cantPie * $madera['madPrecio'];
									} else {
										//Se vende por pulgada
										$precio = $cantPul * $madera['madPrecioPulgada'];
									}

									$acumulado += ($precio * $item_['artDetCantidad']);
								} else {
									$acumulado += ($item_['artPrecio'] * $item_['artDetCantidad']);
								}
							}

							//Calcular precio de venta
							$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $acumulado);
						}
					}
					$articles = $item;
				}
			}
		}
		return $articles;
	}


	function searchByAll($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$art = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artEstado'=>'AC', 'artEsSimple' => 1));
		if($str != ''){
			$this->db->like('artId',$str);
			$this->db->or_like('artDescripcion',$str);
		}
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			foreach ($query->result_array() as $item) {
				if($item['madId'] != null){
					//Calcular precio con el valor de la madera
					
					$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
					if ($query->num_rows() != 0)
					{
						$m = $query->result_array();
						$madera = $m[0];
					}

					$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
					$cantPul = $cantPie * 3.77;

					$precio = 0;
					if($item['artSeVendePorPie'] == true){
						//Se vende por pie
						$precio = $cantPie * $madera['madPrecio'];
					} else {
						//Se vende por pulgada
						$precio = $cantPul * $madera['madPrecioPulgada'];
					}

					$item['artPrecio'] = $precio;
				} 
				$art[] = $item;
			}
		}

		return $art;
	}
	function searchByAllConStock($data = null){
		$str = '';
		$depId = 0;
		if($data != null){
			$str = $data['code'];
			$depId = $data['depId'];
		}

		$art = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artEstado'=>'AC', 'artEsSimple' => 1));
		if($str != ''){
			$this->db->like('artId',$str);
			$this->db->or_like('artDescripcion',$str);
		}
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			foreach ($query->result_array() as $item) {
				if($item['artEsSimple'] == 1){
					if($item['madId'] != null){
						//Calcular precio con el valor de la madera
						
						$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
						if ($query->num_rows() != 0)
						{
							$m = $query->result_array();
							$madera = $m[0];
						}

						$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
						$cantPul = $cantPie * 3.77;

						$precio = 0;
						if($item['artSeVendePorPie'] == true){
							//Se vende por pie
							$precio = $cantPie * $madera['madPrecio'];
						} else {
							//Se vende por pulgada
							$precio = $cantPul * $madera['madPrecioPulgada'];
						}

						$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $precio);
					} else {
						$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $item['artPrecio']);
					} 
				} else {
					//Sumar los precios de todos los items del detalle 
					//Articulos extras
					//$data['article']['detail'] = array();
					$acumulado = 0;
					$this->db->select('articulosdetalle.artId_, articulos.artDescripcion, articulosdetalle.artDetCantidad, articulos.madId, articulos.artPrecio, articulos.artlargo, articulos.artEspesor, articulos.artAlto, articulos.artSeVendePorPie');
					$this->db->from('articulosdetalle');
					$this->db->join('articulos', 'articulos.artId = articulosdetalle.artId_');
					$this->db->where(array('articulosdetalle.artId' => $item['artId']));
					$query2 = $this->db->get();
					if ($query2->num_rows()!=0)
					{
						$detalle = $query2->result_array();
						foreach ($detalle as $item_) {
							if($item_['madId'] != null){
								//Calcular precio con el valor de la madera
								
								$query3= $this->db->get_where('maderas',array('madId' => $item_['madId']));
								if ($query3->num_rows() != 0)
								{
									$m = $query3->result_array();
									$madera = $m[0];
								}

								$cantPie = ($item_['artlargo'] * $item_['artAlto'] * $item_['artEspesor'] * 4.24) / 10000000;
								$cantPul = $cantPie * 3.77;

								$precio = 0;
								if($item_['artSeVendePorPie'] == true){
									//Se vende por pie
									$precio = $cantPie * $madera['madPrecio'];
								} else {
									//Se vende por pulgada
									$precio = $cantPul * $madera['madPrecioPulgada'];
								}

								$acumulado += ($precio * $item_['artDetCantidad']);
							} else {
								$acumulado += ($item_['artPrecio'] * $item_['artDetCantidad']);
							}
						}

						//Calcular precio de venta
						$item['artPrecio'] = $this->CalcularPrecioVenta($item['artId'], $acumulado);
					}
					////----------------------------------------------
				}

				$item['stock'] = $this->CalcularStock($item['artId'], $item['artEsSimple'], $depId);//array('stock' => 10, 'potencial' => 1);
				$art[] = $item;
			}
		}

		return $art;
	}

	function CalcularPrecioVenta($artId, $coste){
		$pVenta = $coste;
		//Datos del articulo
		$query= $this->db->get_where('articulos',array('artId'=>$artId));
		if ($query->num_rows() > 0)
		{
			$a = $query->result_array();
			$art = $a[0];
			
			//Operativo
			if($art['artOperativoEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artOperativo'] / 100);
			} else {
				$pVenta += $art['artOperativo'];
			}

			//Estructura
			if($art['artEstructuraEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artEstructura'] / 100);
			} else {
				$pVenta += $art['artEstructura'];
			}

			//Fletes
			if($art['artFleteEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artFlete'] / 100);
			} else {
				$pVenta += $art['artFlete'];
			}

			//Servicio
			if($art['artServicioEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artServicio'] / 100);
			} else {
				$pVenta += $art['artServicio'];
			}

			//Otros Costos
			if($art['artOtrosCostosEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artOtrosCostos'] / 100);
			} else {
				$pVenta += $art['artOtrosCostos'];
			}

			//Margen
			if($art['artMargenEsPorcentaje'] == 1){
				$pVenta += $pVenta * ($art['artMargen'] / 100);
			} else {
				$pVenta += $art['artMargen'];
			}
		}

		return number_format($pVenta, 3);
	}
	
	function CalcularStock($artId, $esSimple, $depId){
		//Calcular stock simple
		$this->db->select_sum('stkCant', 'stock');
	    $this->db->from('stock');
	    $this->db->where(array('depId'=> $depId, 'artId'=> $artId));
	    $query = $this->db->get();
	    $result = $query->result();
    	$stock = $result[0]->stock;

    	if($stock == null){
    		$stock = 0;
    	}
    	
    	//Potencial-----------------------------------
    	if($esSimple == false){
    		$potencial = 'xx';
    		$query= $this->db->get_where('articulosdetalle',array('artId'=>$artId));
			$arts = $query->result_array();

			$stk = array();

			foreach ($arts as $a) {
				//Stock Actual
				$this->db->select('sum(stkCant) as cantidad, '.$a['artDetCantidad'].' as requiere');
				$this->db->from('stock');
				$this->db->where(array('artId' => $a['artId_'], 'depId' => $depId));
				$query= $this->db->get();
				$stk[] = $query->result_array();
			}
			
			$potencial = 'x';
			foreach ($stk as $s) {
				if($s[0]['cantidad'] < 0){
					$pot = 0;
				} else {
					$pot = floor($s[0]['cantidad'] / $s[0]['requiere']);
				}
				if($pot == 0){
					$potencial = 0;	
					break;
				} else {
					if($potencial == 'x'){
						$potencial = $pot;
					} else {
						if($potencial > $pot){
							$potencial = $pot;
						}
					}
				}
			}
    	} else{
    		$potencial = '-';
    	}
    	//--------------------------------------------
    	//Pedido--------------------------------------
    	$this->db->select('sum(orddCantidad) as cantidad');
    	$this->db->from('ordendetrabajodetalle');
    	$this->db->join('ordendetrabajo', 'ordendetrabajo.ordId = ordendetrabajodetalle.ordId');
    	$condition = array('DS', 'CR');
    	$this->db->where_not_in('ordEstado' , $condition);
    	$this->db->where(array('artId' => $artId, 'depId' => $depId));
    	$query = $this->db->get();
    	$result = $query->result_array();
    	$pedido = $result[0]['cantidad'] == null ? 0 : $result[0]['cantidad'];
    	//--------------------------------------------
		return array('stock' => $stock, 'potencial' => $potencial, 'pedido' => $pedido);
	}

	function searchByAllNotSingle($data = null){
		$str = '';
		if($data != null){
			$str = $data['code'];
		}

		$art = array();

		$this->db->select('*');
		$this->db->from('articulos');
		$this->db->where(array('artEstado'=>'AC'));
		if($str != ''){
			$this->db->like('artId',$str);
			$this->db->or_like('artDescripcion',$str);
		}
		$this->db->order_by('artDescripcion');
		$query = $this->db->get();
		if ($query->num_rows()!=0)
		{
			foreach ($query->result_array() as $item) {
				if($item['madId'] != null){
					//Calcular precio con el valor de la madera
					
					$query= $this->db->get_where('maderas',array('madId' => $item['madId']));
					if ($query->num_rows() != 0)
					{
						$m = $query->result_array();
						$madera = $m[0];
					}

					$cantPie = ($item['artlargo'] * $item['artAlto'] * $item['artEspesor'] * 4.24) / 10000000;
					$cantPul = $cantPie * 3.77;

					$precio = 0;
					if($item['artSeVendePorPie'] == true){
						//Se vende por pie
						$precio = $cantPie * $madera['madPrecio'];
					} else {
						//Se vende por pulgada
						$precio = $cantPul * $madera['madPrecioPulgada'];
					}

					$item['artPrecio'] = $precio;
				} 
				$art[] = $item;
			}
		}

		return $art;
	}
}
?>