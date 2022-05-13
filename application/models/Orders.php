<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Orders extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Reception_List($data_ = null){
		$data = array();
		
		if($data_ == null){		
			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Order by ordId desc  
				Limit 0, 10 ');

			$data['page'] = 1;
			$data['totalPage'] = ceil($this->db->count_all_results('ordendetrabajo') / 10);
			$data['data'] = $query->result_array();
		} else {
			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordId like \'%'.$data_['txt'].'%\' or 
					  ordFecha like \'%'.$data_['txt'].'%\' or 
					  ordObservacion like \'%'.$data_['txt'].'%\' or 
					  cliNombre like \'%'.$data_['txt'].'%\' or 
					  cliApellido like \'%'.$data_['txt'].'%\' or 
					  depNombre like \'%'.$data_['txt'].'%\'
				Order by ordId desc 
				Limit '.(($data_['page'] - 1) * 10).', 10 ');

			$data['page'] = $data_['page'];
			$data['data'] = $query->result_array();

			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordId like \'%'.$data_['txt'].'%\' or 
					  ordFecha like \'%'.$data_['txt'].'%\' or 
					  ordObservacion like \'%'.$data_['txt'].'%\' or 
					  cliNombre like \'%'.$data_['txt'].'%\' or 
					  cliApellido like \'%'.$data_['txt'].'%\' or 
					  depNombre like \'%'.$data_['txt'].'%\'
				Order by ordId desc ');

			$data['totalPage'] = ceil($query->num_rows() / 10);
		}
		
		return $data;
	}

	function Production_List($data_ = null){
		$data = array();
		
		if($data_ == null){
			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				Left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordEstado in (\'RC\', \'PR\', \'PA\', \'EN\', \'EP\')
				Order by ordId desc  
				Limit 0, 10 ');
			
			$data['page'] = 1;
			$data['data'] = $query->result_array();

			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				Left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordEstado in (\'RC\', \'PR\', \'PA\', \'EN\', \'EP\')
				Order by ordId desc ');

			$data['totalPage'] = ceil($query->num_rows() / 10);
		} else {

			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				Left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordId like \'%'.$data_['txt'].'%\' or 
					  ordFecha like \'%'.$data_['txt'].'%\' or 
					  ordObservacion like \'%'.$data_['txt'].'%\' or 
					  cliNombre like \'%'.$data_['txt'].'%\' or 
					  cliApellido like \'%'.$data_['txt'].'%\' or 
					  depNombre like \'%'.$data_['txt'].'%\' and 
					  (
					  	ordEstado in (\'RC\', \'PR\', \'PA\', \'EN\', \'EP\')
					  )
				Order by ordId desc 
				Limit '.(($data_['page'] - 1) * 10).', 10 ');

			$data['page'] = $data_['page'];
			$data['data'] = $query->result_array();

			$query = $this->db->query('
				Select ordendetrabajo.*, clientes.cliNombre, clientes.cliApellido, depositos.depNombre 
				From ordendetrabajo 
				Left Join clientes on clientes.cliId = ordendetrabajo.cliId 
				Join depositos on depositos.depId = ordendetrabajo.depId 
				Where ordId like \'%'.$data_['txt'].'%\' or 
					  ordFecha like \'%'.$data_['txt'].'%\' or 
					  ordObservacion like \'%'.$data_['txt'].'%\' or 
					  cliNombre like \'%'.$data_['txt'].'%\' or 
					  cliApellido like \'%'.$data_['txt'].'%\' or 
					  depNombre like \'%'.$data_['txt'].'%\' and 
					  (
					  	ordEstado in (\'RC\', \'PR\', \'PA\', \'EN\', \'EP\')
					  )
				Order by ordId desc ');

			$data['totalPage'] = ceil($query->num_rows() / 10);
		}
		
		return $data;
	}
	
	function getOrder($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = isset($data['act']) ? $data['act'] : 'RC';
			$id = $data['id'];

			$data = array();
			$data['articles'] = array();

			$data['isInterne'] = false;
			if($action == 'Int'){ $data['isInterne'] = true; }

			$this->db->select('cliId, cliNombre, cliApellido, cliDocumento, cliDomicilio, cliTipo');
			$this->db->from('clientes');
			$this->db->order_by('cliApellido','cliNombre');
			$this->db->where(array('cliEstado'=>'AC'));
			$query = $this->db->get();
			$data['customers'] = $query->result_array();

			$this->db->select('depId, depNombre');
			$this->db->from('depositos');
			$this->db->order_by('depNombre');
			$this->db->where(array('depEstado'=>'AC'));
			$query = $this->db->get();
			$data['deposit'] = $query->result_array();

			$query= $this->db->get_where('ordendetrabajo',array('ordId'=>$id));
			if ($query->num_rows() != 0)
			{
				$o = $query->result_array();
				$data['order'] = $o[0];

				//Si no tiene cliente es orden interna
				if($data['order']['cliId'] == null){ $data['isInterne'] = true; }

				$query = $this->db->get_where('sisusers', array('usrId' => $o[0]['usrId']));
				$u = $query->result_array();
				$data['user'] = $u[0]['usrNick'];
				
				if($action == 'EntrM'){
					$this->db->select('ordendetrabajodetalle.*, sum(remitodetalle.remdCantidad) as entregado');
					$this->db->from('ordendetrabajodetalle');
					$this->db->join('remitodetalle', 'remitodetalle.orddid = ordendetrabajodetalle.orddid', 'left');
					$this->db->where(array('ordId'=>$id));
					$this->db->group_by("ordendetrabajodetalle.orddid");
					$query = $this->db->get();
					$data['articles'] = $query->result_array();

					$query = $this->db->get_where('remito', array('ordId' => $id));
					$data['remitos'] = $query->result_array();

				} else {
					$this->db->select('ordendetrabajodetalle.*, ivas.ivaPorcent');
					$this->db->from('ordendetrabajodetalle');
					$this->db->join('articulos', 'articulos.artId = ordendetrabajodetalle.artId', 'left');
					$this->db->join('ivas', 'ivas.ivaId = articulos.ivaId', 'left');
					$this->db->where(array('ordId'=>$id));
					$query = $this->db->get();
					//$query = $this->db->get_where('ordendetrabajodetalle', );
					$data['articles'] = $query->result_array();
				}

				if($action == 'Entr' || $action == 'Finaly'){
					$this->db->select('ordendetrabajodetalle.orddid, ordendetrabajodetalle.ordId, ordendetrabajodetalle.artId, ordendetrabajodetalle.artDescripcion, ordendetrabajodetalle.orddCantidad, ordendetrabajodetalle.orddReserva, sum(ordendetrabajoentregas.ordEntCantidad) as entregado');
					$this->db->from('ordendetrabajodetalle');
					$this->db->join('ordendetrabajoentregas', 'ordendetrabajoentregas.orddid = ordendetrabajodetalle.orddid', 'left');
					$this->db->where(array('ordId'=>$id));
					$this->db->group_by("ordendetrabajodetalle.orddid");
					$query = $this->db->get();
					$data['articles_ent'] = $query->result_array();
				}
				
			} else {
				$o = array();
				$o['ordId'] = '';
				$o['cliId'] = '';
				$o['ordFecha'] = '';
				$o['ordObservacion'] = '';
				$o['ordNumeroOC'] = '';
				$o['ordEstado'] = '';
				$userdata = $this->session->userdata('user_data');
				$o['user'] = $userdata[0]['usrNick'];;
				$data['order'] = $o;
			}

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View' || $action == 'Conf' || $action == 'Disc'){
				$readonly = true;
			}
			$data['read'] = $readonly;
			$data['action'] = $action;

			return $data;
		}
	}
	
	function setOrder($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$userdata = $this->session->userdata('user_data');
			$usrId = $userdata[0]['usrId'];

			$id 	= $data['id_'];
	        $act 	= $data['act'];
	        $depId  = $data['depId'];
	        $cliId  = $data['cliId'];
	        $obsv 	= $data['obsv'];
	        $oc 	= $data['OC'];
	        $est 	= $data['est'];
	        $det 	= isset($data['det']) ? $data['det'] : array();
			$fecha 	= $data['fecha'];
			
			$data = array(
					   'cliId'		 	=> $cliId,
					   'ordObservacion'	=> $obsv,
					   'ordNumeroOC'	=> $oc,
					   'depId'			=> $depId
					);
			
			switch($act){
				case 'Add':
				case 'Int':
					//Setear Iva 
					$calcularIva = false;

					if($act == 'Int') { 
						$data['cliId'] = null; 
					} else {
						//getCustomer
						$this->load->model('Customers');
						$cliente = $this->Customers->getCustomer(array('id'=> $cliId, 'act'=>'View'));
						if($cliente['customer']['cliTipo'] == 'BL'){
							$calcularIva = true;
						}
					}

					$data['ordEstado'] = 'RC';
					$data['usrId'] = $usrId;

					if($this->db->insert('ordendetrabajo', $data) == false) {
						return false;
					} else{
						$ordId = $this->db->insert_id();
						//Detalle
						foreach ($det as $d) {
							if($calcularIva == true){
								$this->db->select('ivas.ivaPorcent');
								$this->db->from('articulos');
								$this->db->join('ivas', 'ivas.ivaId = articulos.ivaId', 'left');
								$this->db->where(array('artId'=>$d['artId']));
								$query = $this->db->get();
								$ivaImporte = $query->result_array();
								$ivaImporte = $ivaImporte[0]['ivaPorcent'];
							} else {
								$ivaImporte = 0;
							}
							$insert = array(
									'ordId' 			=> $ordId,
									'artId' 			=> $d['artId'],
									'artDescripcion'	=> $d['artDesc'],
									'artPrecio'			=> $d['artPrecio'],
									'orddCantidad'		=> $d['orddCant'],
									'artIva'			=> $ivaImporte > 0 ? ($d['artPrecio'] * ($ivaImporte / 100)) : $ivaImporte
								);

							if($this->db->insert('ordendetrabajodetalle', $insert) == false) {
								return false;
							}
						}	
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $ordId,
										'ordEstadoActual' => 'RC'
									);
						$this->registerLog($logData);
					}

					break;

				case 'Edit':
					$data = array(
					   'cliId'		 	=> ($cliId == 0 ? null : $cliId),
					   'ordObservacion'	=> $obsv,
					   'ordNumeroOC'	=> $oc,
					   'depId'			=> $depId
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					} else {
						//Detalle
						if($this->db->delete('ordendetrabajodetalle', array('ordId'=>$id)) == false) {
					 		return false;
					 	} else {
					 		foreach ($det as $d) {
								$insert = array(
										'ordId' 			=> $id,
										'artId' 			=> $d['artId'],
										'artDescripcion'	=> $d['artDesc'],
										'artPrecio'			=> $d['artPrecio'],
										'orddCantidad'		=> $d['orddCant']
									);

								if($this->db->insert('ordendetrabajodetalle', $insert) == false) {
									return false;
								}
							}	
						}
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'ED',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;
				
				case 'Pause':
					$data = array(
					   'ordEstado'		=> 'PA'
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					}else{
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'PA',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;

				case 'Play':
					$data = array(
					   'ordEstado'		=> 'PR'
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					}else{
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'PR',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;

				case 'Disc':
					$data = array(
					   'ordEstado'		=> 'DS'
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					}else{
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'DS',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;

				case 'Finaly':
					$data = array(
					   'ordEstado'		=> 'FN'
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					}else{
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'FN',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;

				case 'Close':
					$data = array(
					   'ordEstado'		=> 'CR'
					);
					if($this->db->update('ordendetrabajo', $data, array('ordId'=>$id)) == false) {
						return false;
					}else{
						//Log
						$logData = array(
										'usrId' => $usrId,
										'ordId'	=> $id,
										'ordEstadoActual' 	=> 'CR',
										'ordEstadoAnterior' => $est
									);
						$this->registerLog($logData);
					}
					break;

				case 'EntrM':
					$remito = array(
						'usrId' 	=> $usrId,
						'ordId'		=> $id
						);

					if($cliId == 0 || $cliId == null){
						$remito['remNumero'] = $this->getNumero('Int');
					} else {
						$query= $this->db->get_where('clientes',array('cliId'=>$cliId));
						if ($query->num_rows() != 0) {
							$c = $query->result_array();
							if($c[0]['cliTipo'] == 'BL'){
								$remito['remNumero'] = $this->getNumero('Ext');
							} else {
								$remito['remNumero'] = $this->getNumero('Int');
							}
						} else {
							$remito['remNumero'] = $this->getNumero('Int');
						}
					}
					
					if($fecha != ''){
						$fecha = explode('-',$fecha);
						$remito['remFecha'] = $fecha[2].'-'.$fecha[1].'-'.$fecha[0].' 09:00:00'; 
					}

					if($this->db->insert('remito', $remito) == false) {
						return false;
					} else{
						$remId = $this->db->insert_id();

						//Detalle
						foreach ($det as $d) {
							$insert = array(
									'remId' 			=> $remId,
									'orddId' 			=> $d['orddId'],
									'remdCantidad'		=> $d['orddCant']
								);

							if($this->db->insert('remitodetalle', $insert) == false) {
								return false;
							} else {
								//Registrar movimiento de stock para el articulo seleccionado
								$insert = array(
									   'depId'			=> $depId,
									   'artId' 			=> $d['artId'],
									   'stkCant'		=> (-1 * $d['orddCant']),
									   'stkOrigen'		=> 'VN'
									);

								if($this->setFit($insert) == false)
								{
									return false;
								}
							}
						}

						return $remId;
					}
					break;
			}
			

			return true;

		}
	}

	function getNumero($type){
		if($type == 'Int'){
			$this->db->set('numTalonario', '`numTalonario`+ 1', FALSE);
			$this->db->where('descTalonario', 'Remitos Internos');
			$this->db->update('talonarios');

			$query= $this->db->get_where('talonarios',array('descTalonario'=>'Remitos Internos'));
			if ($query->num_rows() != 0) {
				$r = $query->result_array();
				return str_pad($r[0]['pvTalonario'], 4, "0", STR_PAD_LEFT).'-'.str_pad($r[0]['numTalonario'], 8, "0", STR_PAD_LEFT);
			} else {
				return '0000-00000000';
			}
		} else {
			$this->db->set('numTalonario', '`numTalonario`+ 1', FALSE);
			$this->db->where('descTalonario', 'Remitos');
			$this->db->update('talonarios');

			$query= $this->db->get_where('talonarios',array('descTalonario'=>'Remitos'));
			if ($query->num_rows() != 0) {
				$r = $query->result_array();
				return str_pad($r[0]['pvTalonario'], 4, "0", STR_PAD_LEFT).'-'.str_pad($r[0]['numTalonario'], 8, "0", STR_PAD_LEFT);
			} else {
				return '0000-00000000';
			}
		}
	}

	function registerLog($data){
		if($this->db->insert('ordendetrabajolog', $data) == false) {
			return false;
		} else{
			return true;
		}
	}

	function getLog($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$data = array();

			//Datos de la Orden
			$query= $this->db->get_where('ordendetrabajo',array('ordId'=>$id));
			$o = $query->result_array();
			$data['order'] = $o[0];

			//Usuario creador
			$query = $this->db->get_where('sisusers', array('usrId' => $o[0]['usrId']));
			$u = $query->result_array();
			$data['user'] = $u[0]['usrNick'];

			//Log de la Orden
			$this->db->select('ordendetrabajolog.*, sisusers.usrNick');
			$this->db->from('ordendetrabajolog');
			$this->db->join('sisusers', 'sisusers.usrId = ordendetrabajolog.usrId');
			$this->db->where(array('ordId' => $id));
			$this->db->order_by('logFecha','Desc');
			$query = $this->db->get();
			$data['log'] = $query->result_array();

			return $data;
		}
	}

	function setReserve($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$cant = $data['cant'];

			$data = array(
					   'orddReserva'	=> $cant
					);
			if($this->db->update('ordendetrabajodetalle', $data, array('orddid'=>$id)) == false) {
				return false;
			}
		}
		return true;
	}

	function setEntregue($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$ordId = $data['ordId'];
			$orddid = $data['orddid'];
			$cant = $data['cant'];

			//Registrar la entrega parcial
			$userdata = $this->session->userdata('user_data');
			$usrId = $userdata[0]['usrId'];

			$data = array(
					   'orddid'	=> $orddid,
					   'ordEntCantidad' => $cant,
					   'usrId' => $usrId
					);
			if($this->db->insert('ordendetrabajoentregas', $data) == false) {
				return false;
			} else {
				$data = array(
					   'ordEstado'		=> 'EP'
					);
				if($this->db->update('ordendetrabajo', $data, array('ordId'=>$ordId)) == false) {
					return false;
				}

				//Registrar el movimiento de stock
				$this->db->select('ordendetrabajodetalle.artId, articulos.artEsSimple, ordendetrabajo.depId');
				$this->db->from('ordendetrabajodetalle');
				$this->db->join('ordendetrabajo', 'ordendetrabajo.ordId = ordendetrabajodetalle.ordId');
				$this->db->join('articulos', 'articulos.artId = ordendetrabajodetalle.artId');
				$this->db->where(array('ordendetrabajodetalle.orddid'=> $orddid));
				$query = $this->db->get();

				$data = $query->result_array();
				if($data[0]['artEsSimple'] == 0){
					//Buscar composición del articulo
					$query= $this->db->get_where('articulosdetalle',array('artId'=>$data[0]['artId']));
					$arts = $query->result_array();

					foreach ($arts as $a) {
						$insert = array(
						   'depId'			=> $data[0]['depId'],
						   'artId' 			=> $a['artId_'],
						   'stkCant'		=> ($a['artDetCantidad'] * -1) * $cant,
						   'stkOrigen'		=> 'PR'
						);

						if($this->setFit($insert) == false)
						{
							return false;
						}
					}
				} 
				//Registrar movimiento de stock para el articulo seleccionado
				$insert = array(
					   'depId'			=> $data[0]['depId'],
					   'artId' 			=> $data[0]['artId'],
					   'stkCant'		=> $cant,
					   'stkOrigen'		=> 'PR'
					);

				if($this->setFit($insert) == false)
				{
					return false;
				}
			
				$logData = array(
								'usrId' => $usrId,
								'ordId'	=> $ordId,
								'ordEstadoActual' 	=> 'EP',
								'ordEstadoAnterior' => 'PR'
							);
				$this->registerLog($logData);
			}
		}
		return true;
	}

	function setFit($data){
		if($this->db->insert('stock', $data) == false) {
			return false;
		}

		return true;
	}

	function printOrder($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$result = $this->getOrder($data);
			

			$ordId = str_pad($data['id'], 8, "0", STR_PAD_LEFT);

			$fecha = date_create($result['order']['ordFecha']);
			$html  = '<table style="width: 100%;">
						<tr>
							<td style="width: 49%;">
								<center>
									<label><font size="6"><strong>Maderas El Gaucho</strong></font></label><br>
									<label>Calle Corrientes S/N</label><br>
									<label>Tel: 0264-4961020 / 0264-155095890</label>
								</center>
							</td>
							<td style="width:1px; background-color:black;"></td>
							<td style="width: 50%; padding-left: 1cm;">
								<center>
									<label><font size="4"><b>Orden de Pedido</b></font></label><br>
								</center>
								<label>Nro: <b>'.$ordId.'</b></label><br>
								<label>Fecha: <b>'.date_format($fecha, 'd-m-Y H:i:s').'</b></label><br>
								'.($result['order']['cliId'] == null ? '<strong>Orden de Pedido Interna</strong>' : '').'
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr></td>
						</tr>
					  </table>';

			$cliente = false;
			foreach ($result['customers'] as $customer) {
				if($customer['cliId'] == $result['order']['cliId']){
					$cliente = $customer;
					break;
				}
			}

			$html .= '<table style="width: 100%;">
						<tr>
							<td style="width: 10%"">Cliente: </td>
							<td><strong>'.$cliente['cliApellido'].', '.$cliente['cliNombre'].'</strong></td>
						</tr>
						<tr>
							<td style="width: 10%"">Domicilio: </td>
							<td><strong>'.$cliente['cliDomicilio'].'</strong></td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
					  </table>';

			$html .= '<table style="width: 100%;">';
			$html .= '<tr>';
			$html .= '<th>Código</th>';
			$html .= '<th>Descripción</th>';
			$html .= '<th>Cantidad</th>';
			$html .= '<th>Precio</th>';
			$html .= '<th>Total</th>';
			$html .= '</tr>';
			$html .= '<tr><td colspan="5" style="height:1px; background-color:black;"></td></tr>';
			$total = 0;
			$ivas = array();
			foreach($result['articles'] as $a){
				$total += number_format(($a['orddCantidad'] * $a['artPrecio']), 3, '.', '');
				$html .= '<tr>';
				$html .= '<td>'.$a['artId'].'</td>';
				$html .= '<td>'.$a['artDescripcion'].' - '.$a['ivaPorcent'].'</td>';
				$html .= '<td style="text-align: right">'.$a['orddCantidad'].'</td>';
				$html .= '<td style="text-align: right">'.$a['artPrecio'].'</td>';
				$html .= '<td style="text-align: right">'.number_format(($a['orddCantidad'] * $a['artPrecio']), 3, ',', '').'</td>';
				$html .= '</tr>';
				$html .= '<tr><td colspan="5"><hr></td></tr>';
				if(isset($ivas[$a['ivaPorcent']]))
					$ivas[$a['ivaPorcent']] += $a['orddCantidad'] * $a['artPrecio'] * ( ($a['ivaPorcent'] / 100));
					else
					$ivas[$a['ivaPorcent']] = $a['orddCantidad'] * $a['artPrecio'] * ( ($a['ivaPorcent'] / 100));
			}
			$ivai = 0;
			if($cliente['cliTipo'] == 'BL'){
				foreach($ivas as $c=>$i){
					$html .= '<tr>
						<td colspan="3" style="text-align: right"><font size="2"><b>Iva '.$c.'%: </b></font></td>
						<td colspan="2"style="text-align: right"><font size="4"><b>$ '.number_format($i, 3, ',', '').'</b></font></td>
					</tr>';
					$ivai += $i;
				}
			} 
			if($cliente['cliTipo'] == 'BL'){
				$html .= '<tr>
							<td colspan="3" style="text-align: right"><font size="3"><b>SubTotal: </b></font></td>
							<td colspan="2"style="text-align: right"><font size="5"><b>$ '.number_format($total, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '<tr>
					<td colspan="3" style="text-align: right"><font size="4"><b>Total: </b></font></td>
					<td colspan="2"style="text-align: right"><font size="6"><b>$ '.number_format($total + $i, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '</table>';
			} else {
				$html .= '<tr>
							<td colspan="3" style="text-align: right"><font size="4"><b>Total: </b></font></td>
							<td colspan="2"style="text-align: right"><font size="6"><b>$ '.number_format($total, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '</table>';
			}

			//se incluye la libreria de dompdf
			require_once("assets/plugin/HTMLtoPDF/dompdf/dompdf_config.inc.php");
			//se crea una nueva instancia al DOMPDF
			$dompdf = new DOMPDF();
			//se carga el codigo html
			$dompdf->load_html(utf8_decode($html));
			//aumentamos memoria del servidor si es necesario
			ini_set("memory_limit","300M"); 
			//Tamaño de la página y orientación 
			$dompdf->set_paper('A4', 'portrait');
			//lanzamos a render
			$dompdf->render();
			//guardamos a PDF
			//$dompdf->stream("TrabajosPedndientes.pdf");
			$output = $dompdf->output();
			file_put_contents('assets/reports/orders/'.$ordId.'.pdf', $output);

			//Eliminar archivos viejos ---------------
			$dir = opendir('assets/reports/orders/');
			while($f = readdir($dir))
			{
			 
			if((time()-filemtime('assets/reports/orders/'.$f) > 3600*24*1) and !(is_dir('assets/reports/orders/'.$f)))
			unlink('assets/reports/orders/'.$f);
			}
			closedir($dir);
			//----------------------------------------
			return $ordId.'.pdf';
		}
	}

	function printRemite($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id = $data['id'];
			$data = array();
			$this->db->select('remito.*, clientes.cliNombre, clientes.cliApellido, clientes.cliDomicilio, clientes.cliTipo');
			$this->db->from('remito');
			$this->db->join('ordendetrabajo', 'ordendetrabajo.ordId = remito.ordId');
			$this->db->join('clientes', 'clientes.cliId = ordendetrabajo.cliId');
			$this->db->where(array('remId' => $id));
			$query = $this->db->get();
			$data['remito'] = $query->result_array();
			

			$this->db->select('ordendetrabajodetalle.*, remitodetalle.*, ivas.ivaPorcent');
			$this->db->from('remitodetalle');
			$this->db->join('remito', 'remito.remid = remitodetalle.remid');
			$this->db->join('ordendetrabajodetalle', 'ordendetrabajodetalle.orddid = remitodetalle.orddid');
			$this->db->join('articulos', 'articulos.artId = ordendetrabajodetalle.artId', 'left');
			$this->db->join('ivas', 'ivas.ivaId = articulos.ivaId', 'left');
			$this->db->where(array('remito.remId'=>$id));
			$query = $this->db->get();
			$data['detail'] = $query->result_array();
			

			//$remId = str_pad($data['remito'][0]['remId'], 8, "0", STR_PAD_LEFT);
			$remId = $data['remito'][0]['remNumero'];

			$fecha = date_create($data['remito'][0]['remFecha']);
			$html  = '<table style="width: 100%;">
						<tr>
							<td style="width: 49%;">
								<center>
									<label><font size="6"><strong>Maderas El Gaucho</strong></font></label><br>
									<label>Calle Corrientes S/N</label><br>
									<label>Tel: 0264-4961020 / 0264-155095890</label>
								</center>
							</td>
							<td style="width:1px; background-color:black;"></td>
							<td style="width: 50%; padding-left: 1cm;">
								<center>
									<label><font size="4"><b>Remito de Entrega</b></font></label><br>
								</center>
								<label>Nro: <b>'.$remId.'</b></label><br>
								<label>Fecha: <b>'.date_format($fecha, 'd-m-Y H:i:s').'</b></label><br>
							</td>
						</tr>
						<tr>
							<td colspan="3"><hr></td>
						</tr>
					  </table>';

			$html .= '<table style="width: 100%;">
						<tr>
							<td style="width: 10%"">Cliente: </td>
							<td><strong>'.$data['remito'][0]['cliApellido'].', '.$data['remito'][0]['cliNombre'].'</strong></td>
						</tr>
						<tr>
							<td style="width: 10%"">Domicilio: </td>
							<td><strong>'.$data['remito'][0]['cliDomicilio'].'</strong></td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
					  </table>';
					  
			
			$html .= '<table style="width: 100%;">';
			$html .= '<tr>';
			$html .= '<th>Código</th>';
			$html .= '<th>Descripción</th>';
			$html .= '<th>Cantidad</th>';
			$html .= '<th>Precio</th>';
			$html .= '<th>Total</th>';
			$html .= '</tr>';
			$html .= '<tr><td colspan="5" style="height:1px; background-color:black;"></td></tr>';
			$total = 0;
			$ivas = array();
			foreach($data['detail'] as $a){
				$total += number_format(($a['remdCantidad'] * $a['artPrecio']), 3, '.', '');
				$html .= '<tr>';
				$html .= '<td>'.$a['artId'].'</td>';
				$html .= '<td>'.$a['artDescripcion'].'</td>';
				$html .= '<td style="text-align: right">'.$a['remdCantidad'].'</td>';
				$html .= '<td style="text-align: right">'.$a['artPrecio'].'</td>';
				$html .= '<td style="text-align: right">'.number_format(($a['remdCantidad'] * $a['artPrecio']), 3, '.', ',').'</td>';
				$html .= '</tr>';
				$html .= '<tr><td colspan="5"><hr></td></tr>';
				if(isset($ivas[$a['ivaPorcent']]))
					$ivas[$a['ivaPorcent']] += $a['remdCantidad'] * $a['artIva'];
					else
					$ivas[$a['ivaPorcent']] = $a['remdCantidad'] * $a['artIva'];
			}
			$ivai = 0;
			if($data['remito'][0]['cliTipo'] == 'BL'){
				foreach($ivas as $c=>$i){
					$html .= '<tr>
						<td colspan="3" style="text-align: right"><font size="2"><b>Iva '.$c.'%: </b></font></td>
						<td colspan="2"style="text-align: right"><font size="4"><b>$ '.number_format($i, 3, ',', '').'</b></font></td>
					</tr>';
					$ivai += $i;
				}
			} 
			if($data['remito'][0]['cliTipo'] == 'BL'){
				$html .= '<tr>
							<td colspan="3" style="text-align: right"><font size="3"><b>SubTotal: </b></font></td>
							<td colspan="2"style="text-align: right"><font size="5"><b>$ '.number_format($total, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '<tr>
					<td colspan="3" style="text-align: right"><font size="4"><b>Total: </b></font></td>
					<td colspan="2"style="text-align: right"><font size="6"><b>$ '.number_format($total + $i, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '</table>';
			} else {
				$html .= '<tr>
							<td colspan="3" style="text-align: right"><font size="4"><b>Total: </b></font></td>
							<td colspan="2"style="text-align: right"><font size="6"><b>$ '.number_format($total, 3, ',', '').'</b></font></td>
						</tr>';
				$html .= '</table>';
			}
			// $html .= '<tr>
			// 			<td colspan="3" style="text-align: right"><font size="4"><b>Total: </b></font></td>
			// 			<td colspan="2"style="text-align: right"><font size="6"><b>$ '.number_format($total, 3, '.', ',').'</b></font></td>
			// 		  </tr>';
			// $html .= '</table>';
			
			//se incluye la libreria de dompdf
			require_once("assets/plugin/HTMLtoPDF/dompdf/dompdf_config.inc.php");
			//se crea una nueva instancia al DOMPDF
			$dompdf = new DOMPDF();
			//se carga el codigo html
			$dompdf->load_html(utf8_decode($html));
			//aumentamos memoria del servidor si es necesario
			ini_set("memory_limit","300M"); 
			//Tamaño de la página y orientación 
			$dompdf->set_paper('A4', 'portrait');
			//lanzamos a render
			$dompdf->render();
			//guardamos a PDF
			//$dompdf->stream("TrabajosPedndientes.pdf");
			$output = $dompdf->output();
			file_put_contents('assets/reports/remits/'.$remId.'.pdf', $output);

			//Eliminar archivos viejos ---------------
			$dir = opendir('assets/reports/remits/');
			while($f = readdir($dir))
			{
			 
			if((time()-filemtime('assets/reports/remits/'.$f) > 3600*24*1) and !(is_dir('assets/reports/remits/'.$f)))
			unlink('assets/reports/remits/'.$f);
			}
			closedir($dir);
			//----------------------------------------
			return $remId.'.pdf';
		}
	}

	function getProduction($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$ordId = $data['ordId'];
			$data = array();

			//Log de la Orden
			$this->db->select('ordendetrabajoentregas.*, sisusers.usrNick, ordendetrabajodetalle.*');
			$this->db->from('ordendetrabajoentregas');
			$this->db->join('sisusers', 'sisusers.usrId = ordendetrabajoentregas.usrId');
			$this->db->join('ordendetrabajodetalle', 'ordendetrabajodetalle.orddid = ordendetrabajoentregas.orddid');
			$this->db->where(array('ordendetrabajodetalle.ordId' => $ordId));
			$this->db->order_by('ordEntFecha','Desc');
			$query = $this->db->get();
			$data['log'] = $query->result_array();

			return $data;
		}
	}
}
?>