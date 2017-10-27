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
$tabla1 = array('borderColor'=>'000000', 'borderSize'=> 6/*, "cellMarginTop" => 100*/);
$tabla2 = array('borderSize' => 8, 'borderColor' => '1E1E1E',  'cellMarginTop' => 100, 'rules' => 'cols');
$tabla3 = array('cellMarginTop' => 50, 'rules' => 'cols');
$tabla4 = array(    'borderRightSize' => 50, 'borderBottomColor' => '009900',    'borderBottomSize' => 50, 'borderRightColor' => '00CCFF',    'borderTopSize' => 50, 'borderTopColor' => '00CCFF',    'borderLeftSize' => 50, 'borderLeftColor' => '00CCFF'); 

/**
 * Estilos de celdas
 */
$styleCell = array('valign' => 'center');
$numeracion_1 = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
$numeracion_2 = array('listType' => PHPWord_Style_ListItem::TYPE_NUMBER_NESTED);
$numeracion_3 = array('listType' => PHPWord_Style_ListItem::TYPE_BULLET_FILLED);

/**
 * Sección 1
 */
$seccion1 = $PHPWord->createSection(array('pageSizeW'=>12240, 'pageSizeH'=>15840));

/**
 * Cabecera
 */
$PHPWord->addTableStyle('tabla1', $tabla1);
$cabecera = $seccion1->createHeader();
$table = $cabecera->addTable('tabla1');
$table->addRow(1300);
$table->addCell(4000, $styleCell)->addText('DEVIMED S.A. 811-005-050-3', 'titulo1', $alineacion_centrada);
$table->addCell(10000, $styleCell)->addText('ACTA DE RECIBO FINAL DE OBRA', 'titulo2', $alineacion_centrada);
$cabecera->addTextBreak();

/**
 * Pié de página
 */
$footer = $seccion1->createFooter();
$footer->addPreserveText(utf8_decode('Carrera 43A # 7-50 | Of. 809 - Página {PAGE} de {NUMPAGES}'), 'titulo3', $alineacion_centrada);

$numero = new NumerosALetras();

// Recorrido
foreach ($contratos as $contrato):
	$valor_adicion = 0;
	$plazo_adicion = 0;

	// Recorrido de adiciones
	foreach ($this->contrato_model->listar_adiciones($id_contrato) as $adicion):
		// Aumento de contadores y sumas de adiciones
		// $cont++;
		$plazo_adicion += $adicion->Plazo;
		$valor_adicion += $adicion->Valor;
	endforeach;

	$plazo_adicion = ($plazo_adicion == 0) ? "" : "$plazo_adicion días" ;

	/**
	 * Título
	 */
	$seccion1->addText(utf8_decode("CONTRATO No. $contrato->Numero"), 'parrafo1', $alineacion_centrada);

	// Contratante
	$table = $seccion1->addTable('tabla2');
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('CONTRATANTE'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode($contrato->Contratante), 'parrafo2');

	// Contratista
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('CONTRATISTA'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode($contrato->Contratista), 'parrafo2');

	// Objeto
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('OBJETO'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode($contrato->Objeto), 'parrafo2');

	// Plazo
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('PLAZO'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode(number_format($contrato->Plazo_Inicial, 0, '', '.').' días'), 'parrafo2');

	// Otrosi
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('OTROSÍ'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode($plazo_adicion), 'parrafo2');

	// Valor
	$table->addRow();
	$table->addCell(2000, $styleCell)->addText(utf8_decode('VALOR'), 'parrafo1');
	$table->addCell(11000, $styleCell)->addText(utf8_decode(strtoupper($numero->traducir($contrato->Valor_Inicial)).' ($ '.number_format($contrato->Valor_Inicial,0,',','.').')'), 'parrafo2');

	$seccion1->addTextBreak();

	$seccion1->addText(utf8_decode("El ".$this->auditoria_model->formato_fecha(date('Y-m-d'))." se reunieron las siguientes personas: ______________, en calidad de interventor del contrato representando al CONTRATANTE, y $contrato->Representante_Legal actuando como Gerente y Representante Legal del CONTRATISTA, con el fin de certificar la entrega de una parte y el recibo de la otra, las labores inherentes al COTNRATO No. $contrato->Numero, cuyo objeto es: $contrato->Objeto"), 'parrafo2', $alineacion_justificada);

	$seccion1->addText(utf8_decode("Para efectos del recibo a satisfacción, se certifica que EL CONTRATISTA realizó la última entrega, consolidando en esta la totalidad de las labores comprendidas en el alcance contractual, con lo que se da cumplimiento de su parte de todos los términos u obligaciones contractuales a su cargo, incluidas las relacionadas con el plazo el cual finaliza el ".$this->auditoria_model->formato_fecha($contrato->Fecha_Vencimiento)."."), 'parrafo2', $alineacion_justificada);

	$seccion1->addText(utf8_decode("Se certifica por las partes:"), 'parrafo2', $alineacion_justificada);

	// Numeración: texto, profundidad, estilo de texto, estilo de la numeración
	$seccion1->addListItem(utf8_decode("Las actividades fueron desarrolladas de acuerdo con las normas y especificaciones acordadas contractualmente."), 0, null, $numeracion_1);

	$seccion1->addListItem(utf8_decode("Las labores se ejecutaron dentro del plazo convenido."), 0, null, $numeracion_1);

	$seccion1->addListItem(utf8_decode("La interventoría del contrato da por recibidas las labores a entera satisfacción (y anexa el acta final de obra, donde se discrimina la totalidad de las labores ejecutadas por el contratista y el valor final del contrato)."), 0, null, $numeracion_1);

	$seccion1->addListItem(utf8_decode("Se anexan a la presente los entregables a que se obligó el contratista al momento de la firma del contrato, así:"), 0, null, $numeracion_1);
	$seccion1->addListItem(utf8_decode("Anexo 1"), 1, null, $numeracion_2);
	$seccion1->addListItem(utf8_decode("Anexo 2"), 1, null, $numeracion_2);

	$seccion1->addListItem(utf8_decode("Elegir opción:"), 0, null, $numeracion_1);
	$seccion1->addListItem(utf8_decode("El contratista no tuvo ningún requerimiento durante la ejecución del objeto del contrato."), 0, null, $numeracion_3);
	$seccion1->addListItem(utf8_decode("A pesar de que durante la ejecución del contrato se presentaron requerimientos al contratista en los temas de _________, este atendió las recomendaciones en el tiempo requerido e implementó las acciones pertinentes (y se anexa prueba de ello)."), 0, null, $numeracion_3);
	$seccion1->addListItem(utf8_decode("el contratista tuvo requerimientos por faltas en el cumplimiento de sus obligaciones contractuales, lo cual se evidencia en los informes que se anexan a la presente, por lo que una vez suscrita la presente acta, se procederá con la liquidación del contrato, sin que haya lugar a la devolución del retenido, al que hace referencia la cláusula ___________ del contrato."), 0, null, $numeracion_3);

	$seccion1->addText(utf8_decode("De acuerdo con lo anterior por parte de la interventoría del contrato se expresa que dado el cumplimiento total de las obligaciones contractuales de puede proceder con el acta de liquidación del contrato y la devolución del retenido al CONTRATISTA."), 'parrafo2', $alineacion_justificada);
	
	$seccion1->addText(utf8_decode("Los valores según las labores ejecutadas son los siguientes:"), 'parrafo2', $alineacion_izquierda);
	$seccion1->addTextBreak();

	// Valores
	$table = $seccion1->addTable('tabla2');
	$table->addRow();
	$table->addCell(4000, $styleCell)->addText(utf8_decode("Valor inicial del contrato (incluido IVA)"), 'parrafo1');
	$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($contrato->Valor_Inicial,0,',','.')), 'parrafo2', $alineacion_derecha);

	$table->addRow();
	$table->addCell(4000, $styleCell)->addText(utf8_decode("Valor otrosí adición (incluido IVA)"), 'parrafo1');
	$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format($valor_adicion,0,',','.')), 'parrafo2', $alineacion_derecha);

	$table->addRow();
	$table->addCell(4000, $styleCell)->addText(utf8_decode(""), 'parrafo1');
	$table->addCell(1500, $styleCell)->addText(utf8_decode("______________"), 'parrafo2', $alineacion_derecha);

	$table->addRow();
	$table->addCell(4000, $styleCell)->addText(utf8_decode("Valor total ejecutado (incluido IVA)"), 'parrafo1');
	$table->addCell(1500, $styleCell)->addText(utf8_decode('$ '.number_format(($contrato->Valor_Inicial + $valor_adicion),0,',','.')), 'parrafo2', $alineacion_derecha);
	$seccion1->addTextBreak();

	$seccion1->addText(utf8_decode("En constancia de recibo a satisfacción, se firma por las partes el ".$this->auditoria_model->formato_fecha(date('Y-m-d').".")), 'parrafo2', $alineacion_justificada);
	$seccion1->addTextBreak();
	$seccion1->addTextBreak();
	$seccion1->addTextBreak();

	// Firmas
	$table = $seccion1->addTable('tabla2');
	$table->addRow();
	$table->addCell(6500, $styleCell)->addText(utf8_decode("Interventor o encargado de seguimiento"), 'parrafo1');
	$table->addCell(6500, $styleCell)->addText(utf8_decode($contrato->Representante_Legal), 'parrafo1');

	$table->addRow();
	$table->addCell(6500, $styleCell)->addText(utf8_decode($contrato->Contratante), 'parrafo2');
	$table->addCell(6500, $styleCell)->addText(utf8_decode($contrato->Contratista), 'parrafo2');
	$seccion1->addTextBreak();

	$seccion1->addText(utf8_decode(""), 'parrafo2', $alineacion_justificada);

	// Anexos
	$table = $seccion1->addTable('tabla2');
	$table->addRow();
	$table->addCell(1000, $styleCell)->addText(utf8_decode("ANEXOS"), 'parrafo2');
	$table->addCell(4000, $styleCell)->addText(utf8_decode("_____________"), 'parrafo2');

	$table->addRow();
	$table->addCell(1000, $styleCell)->addText("", 'parrafo2');
	$table->addCell(4000, $styleCell)->addText(utf8_decode("_____________"), 'parrafo2');
endforeach;




// At least write the document to webspace:
$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');

$temp_file_uri = tempnam('', 'xyz');
$objWriter->save($temp_file_uri);

//download code
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename=Acta_Recibo_'.$contrato->Numero.'.docx');
// header('Content-Disposition: attachment; filename=Acta_Recibo.docx');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Content-Length: ' . filesize($temp_file_uri));
readfile($temp_file_uri);
unlink($temp_file_uri); // deletes the temporary file
exit;
?>