<?php 

	include "../conexion.php";
	$products = [];
	$query = mysqli_query($conection, "SELECT banner_id, foto FROM banner");

	$data =  mysqli_fetch_all($query);
	$result = mysqli_num_rows($query);
	if($result > 0){
		while(count($products) < 1){

			$i = rand(0, $result -1);
			if(!in_array($i, $products)){
				array_push($products, $i);
				}
			}

		foreach($products as $product){
			$p           = $data[$product];
			$foto        = $p[1];

			if($foto != 'img_producto.png'){
				$foto = 'img/banner/'.$foto;
			}else{
				$foto = 'img/'.$foto;
			}
			
			?>
			<div >
					<img  src="<?php echo $foto; ?>">
			</div>

			<?php
		}
}

?> 