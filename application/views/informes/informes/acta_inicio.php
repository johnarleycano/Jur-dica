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
$properties->setCreator('carlos florez'); 
$properties->setCompany('Devimed S.A');
$properties->setTitle('Acta de inicio');
$properties->setDescription('Acta de inicio de obra'); 
$properties->setCategory('informe');
$properties->setLastModifiedBy('carlos florez');

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
$PHPWord->addFontStyle('titulo4', array('color'=>'000000', 'bold'=> true));


$PHPWord->addFontStyle('parrafo1', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('parrafo2', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));
$PHPWord->addFontStyle('parrafo3', array( 'name'=>'Arial', 'size'=> 8, 'color'=>'000000', 'bold'=> false));
$PHPWord->addFontStyle('parrafo4', array( 'name'=>'Arial', 'size'=> 11, 'color'=>'000000', 'bold'=> true));


/**
 * Estilos de las tablas
 */
$tabla1 =array('borderColor'=>'000000', 'borderSize'=> 6);
$tabla2 = array('borderSize' => 8, 'borderColor' => '1E1E1E',  'cellMarginTop' => 100, 'rules' => 'cols');
$tabla3 = array('cellMarginTop' => 2, 'rules' => 'cols');
$tabla4 = array(    'borderRightSize' => 50, 'borderBottomColor' => '009900',    'borderBottomSize' => 50, 'borderRightColor' => '00CCFF',    'borderTopSize' => 50, 'borderTopColor' => '00CCFF',    'borderLeftSize' => 50, 'borderLeftColor' => '00CCFF');

$tabla5 = array(
  // 'borderColor' => 'F2F2F2',
  // 'borderSize' => '0',
  'cellMargin' => '0',
  // 'bgColor' => '088A68'

); 


/** 
*Estilos de parrafos

*/

$PHPWord->addParagraphStyle('pStyle', array('align' => 'left', 'spaceAfter'=>5));


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
// $PHPWord->addTableStyle('tabla1', $tabla1);
// $cabecera = $seccion1->createHeader();
// $table = $cabecera->addTable('tabla1');
// $table->addRow(1300);
// $table->addCell(4000, $styleCell)->addText('DEVIMED S.A 811.005.050-3', 'titulo1', $alineacion_centrada);
// $table->addCell(10000, $styleCell)->addText('ACTA DE INICIO DE OBRA', 'titulo2', $alineacion_centrada);
// $cabecera->addTextBreak();

/**
 * Pié de página
 */
$footer = $seccion1->createFooter();
$footer->addPreserveText(utf8_decode('Cra. 43A No. 7-50 Torre financiera Dann- Página {PAGE} de {NUMPAGES}'), 'titulo3', $alineacion_centrada);

// Recorrido
foreach ($contratos as $contrato):
	/**
	 * Título
	 */
	$contrac= substr($contrato->Numero,0,4)."-".substr($contrato->Numero,4,4);	
	$seccion1->addText(utf8_decode('ACTA DE INICIO'), 'parrafo1', $alineacion_centrada);
	// $seccion1->addText(utf8_decode('CONTRATO No. '.$contrato->Numero), 'parrafo1', $alineacion_centrada);
	$seccion1->addText(utf8_decode('CONTRATO No. '.$contrac), 'parrafo1', $alineacion_centrada);

	$seccion1->addTextBreak();

	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(4000)->addText(utf8_decode('CONTRATANTE: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(9000)->addText(utf8_decode('DEVIMED S.A. CON NIT: 811.005.050-3'), 'parrafo2', $alineacion_izquierda);

	$table->addRow();
	$table->addCell(4000)->addText(utf8_decode('CONTRATISTA: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(9000)->addText(utf8_decode($contrato->Contratista.' CON NIT: '.$contrato->Documento_Contratista), 'parrafo2', $alineacion_izquierda);
	$seccion1->addTextBreak();

	$seccion1->addText(utf8_decode('El '.$this->auditoria_model->formato_fecha(date('Y-m-d')).' se reunieron en las oficinas de DEVIMED S.A, ' .$contrato->Representante_Legal. ' en representación de '.$contrato->Contratista.', y GERMAN IGNACIO VELEZ VILLEGAS en representación de DEVIMED S.A.'), 'estilo2', $alineacion_justificada);
	$seccion1->addTextBreak();

	$seccion1->addText(utf8_decode('ACUERDAN'), 'parrafo1', $alineacion_centrada);

	$seccion1->addText(utf8_decode('Suscribir el acta de inicio de obra, para efectos de determinar el inicio del plazo del Contrato N° '.$contrac.', cuyo objeto es el siguiente: '), 'estilo2', $alineacion_justificada);

	// Objeto
	$seccion1->addText(utf8_decode($contrato->Objeto), 'parrafo2', $alineacion_justificada);
	$seccion1->addTextBreak();

	// Condiciones contractuales	
	// $seccion1->addText('CONDICIONES CONTRACTUALES', 'parrafo1', $alineacion_centrada);

	// Fecha de inicio
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('FECHA DE INICIO CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(8000)->addText(utf8_decode($this->auditoria_model->formato_fecha($contrato->Fecha_Inicial)), 'parrafo2', $alineacion_izquierda);

	// Fecha de vencimiento
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('FECHA DE TERMINACIÓN: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(8000)->addText(utf8_decode($this->auditoria_model->formato_fecha($contrato->Fecha_Vencimiento)), 'parrafo2', $alineacion_izquierda);

	// Plazo
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('PLAZO DE EJECUCIÓN: '), 'parrafo1', $alineacion_izquierda);
	$table->addCell(8000)->addText(utf8_decode(number_format($contrato->Plazo_Inicial, 0, '', '.').' días'), 'parrafo2', $alineacion_izquierda);

	// Valor
	$table = $seccion1->addTable();
	$table->addRow();
	$table->addCell(5000)->addText(utf8_decode('VALOR DEL CONTRATO: '), 'parrafo1', $alineacion_izquierda);
	$numero = new NumerosALetras();
	$table->addCell(8000)->addText(utf8_decode(strtoupper($numero->traducir($contrato->Valor_Inicial)).' ($ '.number_format($contrato->Valor_Inicial,2,',','.').'=)'), 'parrafo2', $alineacion_izquierda);
	
endforeach;
$seccion1->addTextBreak();

$seccion1->addText(utf8_decode('En constancia de lo anterior, se firma por los que en ella intervinieron:'), 'parrafo2', $alineacion_justificada);
$seccion1->addTextBreak();


$PHPWord->addTableStyle('tabla5', $tabla5);
$table = $seccion1->addTable('tabla5');
$table->addRow(0);
$table->addCell(1000)->addText('GERMAN IGNACIO VELEZ VILLEGAS', null, 'pStyle');
$table->addCell(1000)->addText(utf8_decode($contrato->Representante_Legal),  null, 'pStyle');
$table->addRow(0);
$table->addCell(8000)->addText('Representante legal', null, 'pStyle');
$table->addCell(8000)->addText('Representante legal',  null, 'pStyle');
$table->addRow(0);
$table->addCell(8000)->addText('DEVIMED S.A.',  null, 'pStyle');
$table->addCell(8000)->addText($contrato->Contratista,  null, 'pStyle');
$table->addRow(0);
$table->addCell(1000)->addText('EL CONTRATANTE',  null, 'pStyle');
$table->addCell(1000)->addText('EL CONTRATISTA',  null, 'pStyle');




// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);

//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=Acta_Inicio_'.$contrato->Numero.'.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file
exit;
?>