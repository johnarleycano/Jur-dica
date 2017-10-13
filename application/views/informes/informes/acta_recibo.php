<?php
// Se obtiene el número de contrato
$id_contrato = $this->uri->segment(3);

// Se consultan los datos del contrato
$contratos = $this->contrato_model->listar_contratos($id_contrato);

// Se crea el nuevo objeto
$PHPWord = new PHPWord();

/**
 * Configuración por defecto
 */
$PHPWord->setDefaultFontName('Arial');
$PHPWord->setDefaultFontSize(11);
$properties = $PHPWord->getProperties();
$properties->setCreator(''); 
$properties->setCompany('');
$properties->setTitle('Acta de recibo');
$properties->setDescription('Acta de recibo final de obra'); 
$properties->setCategory('informe');
$properties->setLastModifiedBy('');

/**
 * Estilos de alineación
 */
$alineacion_centrada = array ('align' => 'center', 'valign' => 'center');
$alineacion_izquierda = array ('align' => 'left', 'valign' => 'center');
$alineacion_derecha = array ('align' => 'right', 'valign' => 'center');
$alineacion_justificada = array ('align' => 'both', 'valign' => 'center');

/**
 * Estilos de las fuentes
 */
$PHPWord->addFontStyle('titulo1', array( 'name'=>'Arial', 'size'=> 18, 'color'=>'000000', 'bold'=> true, 'italic' => true));
$PHPWord->addFontStyle('titulo2', array( 'name'=>'Arial', 'size'=> 12, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('titulo3', array( 'name'=>'Arial', 'size'=> 8, 'color'=>'000000', 'bold'=> true, 'italic' => true));

$PHPWord->addFontStyle('parrafo1', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('parrafo2', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> false));
$PHPWord->addFontStyle('parrafo2', array( 'name'=>'Arial', 'size'=> 8, 'color'=>'000000', 'bold'=> false));

/**
 * Estilos de las tablas
 */
$tabla1 =array('borderColor'=>'000000', 'borderSize'=> 6);
$tabla2 = array('borderSize' => 8, 'borderColor' => '1E1E1E',  'cellMarginTop' => 100, 'rules' => 'cols');
$tabla3 = array('cellMarginTop' => 50, 'rules' => 'cols');
$tabla4 = array(    'borderRightSize' => 50, 'borderBottomColor' => '009900',    'borderBottomSize' => 50, 'borderRightColor' => '00CCFF',    'borderTopSize' => 50, 'borderTopColor' => '00CCFF',    'borderLeftSize' => 50, 'borderLeftColor' => '00CCFF'); 

/**
 * Estilos de celdas
 */
$styleCell = array('valign' => 'center');

/**
 * Sección 1
 */
$seccion1 = $PHPWord->createSection(array(/* 'marginLeft'=>210, 'marginRight'=>200, 'marginTop'=>620, 'marginBottom'=>0,*/'pageSizeW'=>12240, 'pageSizeH'=>15840));

/**
 * Cabecera
 */
$PHPWord->addTableStyle('tabla1', $tabla1);
$cabecera = $seccion1->createHeader();
$table = $cabecera->addTable('tabla1');
$table->addRow(1300);
$table->addCell(4000, $styleCell)->addText('DEVIMED S.A 811-005-050-3', 'titulo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText('ACTA DE RECIBO FINAL DE OBRA', 'titulo2', $alineacion_centrada);
$cabecera->addTextBreak();

/**
 * Pié de página
 */
$footer = $seccion1->createFooter();
$footer->addPreserveText(utf8_decode('Carrera 43a No. 7-50 of. 809 - Página {PAGE} de {NUMPAGES}'), 'titulo3', $alineacion_centrada);

// Recorrido
foreach ($contratos as $contrato):
	/**
	 * Título
	 */
	$seccion1->addText(utf8_decode('CONTRATO No. '.$contrato->Numero), 'parrafo1', $alineacion_centrada);

	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(4000)->addText(utf8_decode('CONTRATISTA: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(9000)->addText(utf8_decode($contrato->Contratista.' CON NIT: '.$contrato->Documento_Contratista), 'parrafo2', $alineacion_izquierda);

	$table->addRow();
	$table->addCell(4000)->addText(utf8_decode('CONTRATANTE: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(9000)->addText(utf8_decode('DEVIMED S.A - CON NIT: 811-005-050'), 'parrafo2', $alineacion_izquierda);

	$seccion1->addText(utf8_decode('El '.$this->auditoria_model->formato_fecha(date('Y-m-d')).', en las oficinas de DEVIMED S.A, ubicadas en el municipio de Medellin (Antioquia), se reunieron el ingeniero GERMAN VELEZ quien actúa en representación de DEVIMED S.A (Contratante), y '.$contrato->Representante_Legal.', quien obra en representación de '.$contrato->Contratista.', con el  fin de suscribir el acta de recibo final de obra del Contrato N° '.$contrato->Numero.', cuyo objeto es el siguiente: '), 'estilo2', $alineacion_justificada);

	// Objeto
	$seccion1->addText(utf8_decode($contrato->Objeto), 'parrafo2', $alineacion_justificada);
	$seccion1->addTextBreak();

	// Condiciones contractuales	
	$seccion1->addText('CONDICIONES CONTRACTUALES', 'parrafo1', $alineacion_centrada);

	// Fecha de inicio
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(6000)->addText(utf8_decode('FECHA DE ELABORACIÓN CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(7000)->addText(utf8_decode($this->auditoria_model->formato_fecha(date('Y-m-d'))), 'parrafo2', $alineacion_izquierda);

	// Fecha Acta de inicio
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('FECHA ACTA DE INICIO DEL CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode($this->auditoria_model->formato_fecha($contrato->Fecha_Acta_Inicio)), 'parrafo2', $alineacion_izquierda);

	// Plazo
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('PLAZO DEL CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(8000)->addText(utf8_decode(number_format($contrato->Plazo_Inicial, 0, '', '.').' días'), 'parrafo2', $alineacion_izquierda);

	// Fecha acta de suspensión
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('FECHA ACTA SUSPENSIÓN CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode(''), 'parrafo2', $alineacion_izquierda);

	// Fecha Acta de reinicio
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('FECHA ACTA DE REINICIO CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode(''), 'parrafo2', $alineacion_izquierda);
	
	// Contador
	$cont = 0;
	$plazo = 0;
	$valor_adicion = 0;

	// Recorrido de adiciones
	foreach ($this->contrato_model->listar_adiciones($id_contrato) as $adicion):
		// Aumento de contadores y sumas de adiciones
		$cont++;
		$plazo += $adicion->Plazo;
		$valor_adicion += $adicion->Valor;
	endforeach;

	// Adiciones
	$numero = new NumerosALetras();
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('NÚMERO DE OTROSIES SUSCRITOS: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode(strtoupper($numero->traducir($cont)).' ('.$cont.')'), 'parrafo2', $alineacion_izquierda);

	// Plazo adiciones
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('PLAZO OTROSÍ: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode(strtoupper($numero->traducir($plazo)).' DÍAS ('.$plazo.')'), 'parrafo2', $alineacion_izquierda);

	// Valor adiciones
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('VALOR OTROSÍ: '), 'parrafo1', $alineacion_izquierda);
	$numero = new NumerosALetras();
	$table->addCell(8000)->addText(utf8_decode(strtoupper($numero->traducir($valor_adicion)).' ($ '.number_format($valor_adicion,0,',','.').')'), 'parrafo2', $alineacion_izquierda);

	// Duración del contrato
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('DURACIÓN DEL CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode(number_format($contrato->Plazo_Inicial + $contrato->Plazo_Adiciones,0,'','.').' DÍAS '), 'parrafo2', $alineacion_izquierda);

	// Fecha estimada de terminación
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('FECHA ESTIMADA DE TERMINACIÓN: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode($this->auditoria_model->formato_fecha($contrato->Fecha_Vencimiento)), 'parrafo2', $alineacion_izquierda);

	// Fecha de terminación de la obra
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(7000)->addText(utf8_decode('FECHA DE TERMINACIÓN DE LA OBRA: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(6000)->addText(utf8_decode($this->auditoria_model->formato_fecha(date('Y-m-d'))), 'parrafo2', $alineacion_izquierda);

	// Valor inicial
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('VALOR DEL CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$numero = new NumerosALetras();
	$table->addCell(8000)->addText(utf8_decode(strtoupper($numero->traducir($contrato->Valor_Inicial)).' ($ '.number_format($contrato->Valor_Inicial,0,',','.').')'), 'parrafo2', $alineacion_izquierda);

	foreach ($this->pago_model->estado_pagos_contrato($id_contrato) as $estado):
		$pagado = $estado->Pagado;
	endforeach;

	// Valor real ejecutado
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('VALOR REAL EJECUTADO: '), 'parrafo1', $alineacion_izquierda);
	$numero = new NumerosALetras();
	$table->addCell(8000)->addText(utf8_decode(strtoupper($numero->traducir($pagado)).' ($ '.number_format($pagado,0,',','.').')'), 'parrafo2', $alineacion_izquierda);

	// Valor real ejecutado
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('MOTIVO DE VARIACIÓN EN PLAZO O EN VALOR: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(8000)->addText(utf8_decode(''), 'parrafo2', $alineacion_izquierda);
	
	// Garantías y pólizas
	$seccion1->addText(utf8_decode('GARANTÍAS Y PÓLIZAS'), 'titulo2', $alineacion_centrada);

	// Valor
	$PHPWord->addTableStyle('tabla2', $tabla1);
	$table = $seccion1->addTable('tabla2');
	$table->addRow();
	$table->addCell(2300, $styleCell)->addText(utf8_decode('PÓLIZA'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('NÚMERO'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('INICIO'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('FIN'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('VALOR'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('ASEGURADORA'), 'parrafo1', $alineacion_centrada);
	$table->addCell(2300, $styleCell)->addText(utf8_decode('VIGENCIA (DÍAS)'), 'parrafo1', $alineacion_centrada);

	// Póliza de cumplimiento
	foreach ($this->contrato_model->listar_poliza_cumplimiento($id_contrato) as $cumplimiento):
		// Si hay valores en la póliza
		if($cumplimiento->Numero != ''){
			// Se muestran los datos en la tabla
			$table->addRow();
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Cumplimiento'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($cumplimiento->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($cumplimiento->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($cumplimiento->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($cumplimiento->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($cumplimiento->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($cumplimiento->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;

	// Póliza de prestaciones
	foreach ($this->contrato_model->listar_poliza_prestaciones($id_contrato) as $prestaciones):
		// Si hay valores en la póliza
		if($prestaciones->Numero != ''){
			// Se muestran los datos en la tabla
			$table->addRow();
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Prestaciones'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($prestaciones->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($prestaciones->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($prestaciones->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($prestaciones->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($prestaciones->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($prestaciones->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;

	// Póliza RC
	foreach ($this->contrato_model->listar_poliza_rc($id_contrato) as $rc):
		// Si hay valores en la póliza
		if($rc->Numero != ''){
			// Se muestran los datos en la tabla
			$table->addRow();
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Responsabilidad civil'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($rc->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($rc->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($rc->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($rc->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($rc->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($rc->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;

	// Póliza de estabilidad
	foreach ($this->contrato_model->listar_poliza_estabilidad($id_contrato) as $estabilidad):
		// Si hay valores en la póliza
		if($estabilidad->Numero != ''){
			// Se muestran los datos en la tabla
			$table->addRow();
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Estabilidad'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($estabilidad->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($estabilidad->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($estabilidad->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($estabilidad->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($estabilidad->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($estabilidad->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;

	// Póliza de anticipos
	foreach ($this->contrato_model->listar_poliza_anticipos($id_contrato) as $anticipos):
		// Si hay valores en la póliza
		if($anticipos->Numero != ''){
			// Se muestran los datos en la tabla
			$table->addRow();
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Anticipos'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($anticipos->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($anticipos->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($anticipos->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($anticipos->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($anticipos->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($anticipos->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;

	// Póliza de calidad
	foreach ($this->contrato_model->listar_poliza_calidad($id_contrato) as $calidad):
		// Si hay valores en la póliza
		if($calidad->Numero != ''){
			$table->addRow();
			// Se muestran los datos en la tabla
			$table->addCell(1500, $styleCell)->addText(utf8_decode('Calidad'), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($calidad->Numero), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($calidad->Fecha_Inicio)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($this->auditoria_model->formato_fecha($calidad->Fecha_Final)), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($calidad->Valor, 0, '', '.')), 'parrafo3', $alineacion_derecha);
			$table->addCell(1500, $styleCell)->addText(utf8_decode($calidad->Nombre), 'parrafo3', $alineacion_izquierda);
			$table->addCell(1500, $styleCell)->addText(utf8_decode(number_format($calidad->Vigencia, 0, '', '.')), 'parrafo3', $alineacion_derecha);
		}
	endforeach;
endforeach;
$seccion1->addTextBreak();

$seccion1->addText(utf8_decode('Las obras del objeto del contrato han sido verificados en campo y recibidas a satisfacción.'), 'parrafo2', $alineacion_justificada);

$seccion1->addText(utf8_decode('A partir de la fecha y dentro del plazo estipulado en el contrato, el contratista deberá presentar los documentos necesarios para realizar la liquidación o cruce final de cuentas del contrato, so pena de incurrir en una causal de incumplimiento del mismo, que será denunciada ante la compañía de seguros que expidió las respectivas garantías.'), 'parrafo2', $alineacion_justificada);

$PHPWord->addTableStyle('tabla3', $tabla3);
$table = $seccion1->addTable('tabla3');
$table->addRow(1000);
$table->addCell(9000)->addText('Por EL CONTRATANTE', 'estilo2', $alineacion_izquierda);
$table->addCell(9000)->addText(utf8_decode('Por EL CONTRATISTA'), $alineacion_centrada);
$table->addRow(50);
$table->addCell(9000)->addText('________________________________', 'estilo2', $alineacion_izquierda);
$table->addCell(9000)->addText('________________________________', 'estilo2', $alineacion_izquierda);
$table->addRow(50);
$table->addCell(9000)->addText('C.C.', 'estilo2', $alineacion_izquierda);
$table->addCell(9000)->addText('C.C.', 'estilo2', $alineacion_izquierda);

// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);

//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
// header('Content-Disposition: attachment; filename=Acta_Recibo.docx');
header('Content-Disposition: attachment; filename=Acta_Recibo_'.$contrato->Numero.'.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file
exit;
?>