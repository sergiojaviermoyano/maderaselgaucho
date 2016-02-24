<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Articles extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Articles_List(){

		$query= $this->db->get('admproducts');
		
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
			$query= $this->db->get_where('admproducts',array('prodId'=>$idArt));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$c[0]['prodImg1'] = ( $c[0]['prodImg1'] != '' ? 'assets/img/products/'.$c[0]['prodImg1'] : '');
				$c[0]['prodImg2'] = ( $c[0]['prodImg2'] != '' ? 'assets/img/products/'.$c[0]['prodImg2'] : '');
				$c[0]['prodImg3'] = ( $c[0]['prodImg3'] != '' ? 'assets/img/products/'.$c[0]['prodImg3'] : '');
				$c[0]['prodImg4'] = ( $c[0]['prodImg4'] != '' ? 'assets/img/products/'.$c[0]['prodImg4'] : '');
				$c[0]['prodImg5'] = ( $c[0]['prodImg5'] != '' ? 'assets/img/products/'.$c[0]['prodImg5'] : '');
				$data['article'] = $c[0];
			} else {
				$art = array();

				$art['prodId'] = '';
				$art['prodCode'] = '';
				$art['prodDescription'] = '';
				$art['prodPrice'] = '';
				$art['prodMargin'] = '';
				$art['prodImg1'] = '';
				$art['prodImg2'] = '';
				$art['prodImg3'] = '';
				$art['prodImg4'] = '';
				$art['prodImg5'] = '';
				$art['prodStatus'] = '';
				$art['sfamId'] = '';

				$data['article'] = $art;
			}

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;

			//Zonas
			$query= $this->db->get('confsubfamily');
			if ($query->num_rows() != 0)
			{
				$data['subfamilys'] = $query->result_array();	
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
            $code = $data['code'];
            $name = $data['name'];
            $price = $data['price'];
            $margin = $data['margin'];
            $sfam = $data['sfam'];
            $status = $data['status'];
            $img1 = $data['img1'];
            $img2 = $data['img2'];
            $img3 = $data['img3'];
            $img4 = $data['img4'];
            $update1 = $data['update1'];
            $update2 = $data['update2'];
            $update3 = $data['update3'];
            $update4 = $data['update4'];


			$data = array(
				   'prodCode' => $code,
				   'prodDescription' => $name,
				   'prodPrice' => $price,
				   'prodMargin' => $margin,
				   'sfamId' => $sfam,
				   'prodStatus' => $status
				);

			switch($act){
				case 'Add':
					//Agregar Producto 
					if($this->db->insert('admproducts', $data) == false) {
						return false;
					} else {
						$id = $this->db->insert_id();

						/* Imagen 1 */
						$img = str_replace('data:image/png;base64,', '', $img1);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_1.png', $data);

						$data = array(
								'prodImg1' => $id.'_1.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 		/* Imagen 2 */
						$img = str_replace('data:image/png;base64,', '', $img2);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_2.png', $data);

						$data = array(
								'prodImg2' => $id.'_2.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 		/* Imagen 3 */
						$img = str_replace('data:image/png;base64,', '', $img3);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_3.png', $data);

						$data = array(
								'prodImg3' => $id.'_3.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 		/* Imagen 4 */
						$img = str_replace('data:image/png;base64,', '', $img4);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_4.png', $data);

						$data = array(
								'prodImg4' => $id.'_4.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
					}
					break;
				
				 case 'Edit':
				 	//Actualizar usuario
				 	if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 	}

				 	/* Imagen 1 */
					if($update1 == true) {
						$img = str_replace('data:image/png;base64,', '', $img1);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_1.png', $data);

						$data = array(
								'prodImg1' => $id.'_1.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 	}
			 		/* Imagen 2 */
			 		if($update2 == true) {
						$img = str_replace('data:image/png;base64,', '', $img2);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_2.png', $data);

						$data = array(
								'prodImg2' => $id.'_2.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 	}
			 		/* Imagen 3 */
			 		if($update3 == true) {
						$img = str_replace('data:image/png;base64,', '', $img3);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_3.png', $data);

						$data = array(
								'prodImg3' => $id.'_3.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 	}
			 		/* Imagen 4 */
			 		if($update4 == true) {
						$img = str_replace('data:image/png;base64,', '', $img4);
						$img = str_replace(' ', '+', $img);
						$data = base64_decode($img);
						file_put_contents('assets/img/products/'.$id.'_4.png', $data);

						$data = array(
								'prodImg4' => $id.'_4.png'
							);
						if($this->db->update('admproducts', $data, array('prodId'=>$id)) == false) {
				 		return false;
				 		}
				 	}
				 	break;
					
				 case 'Del':
				 	//Eliminar Articulo
				 	if($this->db->delete('admproducts', array('prodId'=>$id)) == false) {
				 		return false;
				 	}
				 	break;
				 	
			}
			return true;

		}
	}
	
}
?>