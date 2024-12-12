<?php
require_once '../../cOmmOns/config.inc.php';

use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\{QRGdImage, QRCodeOutputException};

/*
 * Class definition
 */

class QRImageWithLogo extends QRGdImage
{

	/**
	 * @param string|null $file
	 * @param string|null $logo
	 *
	 * @return string
	 * @throws \chillerlan\QRCode\Output\QRCodeOutputException
	 */
	public function dump(string $file = null, string $logo = null): string
	{
		// set returnResource to true to skip further processing for now
		$this->options->returnResource = true;

		// of course you could accept other formats too (such as resource or Imagick)
		// i'm not checking for the file type either for simplicity reasons (assuming PNG)
		if (!is_file($logo) || !is_readable($logo)) {
			throw new QRCodeOutputException('invalid logo');
		}

		// there's no need to save the result of dump() into $this->image here
		parent::dump($file);

		$im = imagecreatefrompng($logo);

		// get logo image size
		$w = imagesx($im);
		$h = imagesy($im);

		// set new logo size, leave a border of 1 module (no proportional resize/centering)
		$lw = ($this->options->logoSpaceWidth - 2) * $this->options->scale;
		$lh = ($this->options->logoSpaceHeight - 2) * $this->options->scale;

		// get the qrcode size
		$ql = $this->matrix->size() * $this->options->scale;

		// scale the logo and copy it over. done!
		imagecopyresampled($this->image, $im, ($ql - $lw) / 2, ($ql - $lh) / 2, 0, 0, $lw, $lh, $w, $h);

		$imageData = $this->dumpImage();

		if ($file !== null) {
			$this->saveToFile($imageData, $file);
		}

		if ($this->options->imageBase64) {
			$imageData = $this->toBase64DataURI($imageData, 'image/' . $this->options->outputType);
		}

		return $imageData;
	}
}


function Create1Qr()
{
	/*
 * Runtime
 */

	$options = new QROptions([
		'version'             => 5,
		'eccLevel'            => EccLevel::H,
		'imageBase64'         => false,
		'addLogoSpace'        => true,
		'logoSpaceWidth'      => 17,
		'logoSpaceHeight'     => 17,
		//'bgColor'             => [208, 72, 72],
		'scale'               => 10,
		'imageTransparent'    => false,
		'drawCircularModules' => false,
		'circleRadius'        => 0.45,
		'keepAsSquare'        => [QRMatrix::M_FINDER, QRMatrix::M_FINDER_DOT],
	]);
	//$options->moduleValues        = [
	//	// finder
	//	QRMatrix::M_FINDER_DARK    => [89, 69, 69], // dark (true)
	//	QRMatrix::M_FINDER_DOT     => [89, 69, 69], // finder dot, dark (true)
	//	QRMatrix::M_FINDER         => [255, 255, 255], // light (false), white is the transparency color and is enabled by default
	//	// alignment
	//	QRMatrix::M_ALIGNMENT_DARK => [$colorPrimario],
	//	QRMatrix::M_ALIGNMENT      => [255, 255, 255],
	//	// timing
	//	QRMatrix::M_TIMING_DARK    => [$colorPrimario],
	//	QRMatrix::M_TIMING         => [255, 255, 255],
	//	// format
	//	QRMatrix::M_FORMAT_DARK    => [$colorPrimario],
	//	QRMatrix::M_FORMAT         => [255, 255, 255],
	//	// version
	//	QRMatrix::M_VERSION_DARK   => [$colorPrimario],
	//	QRMatrix::M_VERSION        => [255, 255, 255],
	//	// data
	//	QRMatrix::M_DATA_DARK      => [$colorPrimario],
	//	QRMatrix::M_DATA           => [255, 255, 255],
	//	// darkmodule
	//	QRMatrix::M_DARKMODULE     => [$colorPrimario],
	//	// separator
	//	QRMatrix::M_SEPARATOR      => [255, 255, 255],
	//	// quietzone
	//	QRMatrix::M_QUIETZONE      => [255, 255, 255],
	//	// logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
	//	QRMatrix::M_LOGO           => [255, 255, 255],
	//];
	$qrcode = new QRCode($options);
	$qrcode->addByteSegment('https://maps.app.goo.gl/pDcYeSrnVRjJrXHf8');
	header('Content-type: image/png');
	$qrOutputInterface = new QRImageWithLogo($options, $qrcode->getMatrix());
	//$qrOutputInterface = new QRGdImage($options);
	// dump the output, with an additional logo
	// the logo could also be supplied via the options, see the svgWithLogo example
	// $qrOutputInterface->dump(null, 'logo.png');
	$filename = 'qr_code_with_logo_' . uniqid() . '.png';
	// Ruta donde se guardará la imagen (asegúrate de que el directorio tenga permisos de escritura)
	$filepath = getLocal('QR') . $filename;
	// Guardar la imagen en el servidor
	file_put_contents($filepath, $qrOutputInterface->dump(null, 'LOG.png'));
	exit;
}

function CreateQr($loja_id, $urlSite, $logo, $nombre = '', $colorPrimario = '0,0,0', $colorSecundario = '0,0,0', $QR_CLASSIC = true)
{

	$directoryPath = getLocal('QRS') . $loja_id;
	if (!file_exists($directoryPath)) {
		mkdir($directoryPath, 0777, true);
	}

	$options = new QROptions([
		'version'             => 6,
		'eccLevel'            => EccLevel::H,
		'imageBase64'         => false,
		'addLogoSpace'        => true,
		'logoSpaceWidth'      => 17,
		'logoSpaceHeight'     => 17,
		//'bgColor'             => [208, 72, 72],
		'scale'               => 10,
		'imageTransparent'    => false,
		'drawCircularModules' => $QR_CLASSIC,
		'circleRadius'        => 0.45,
		'keepAsSquare'        => [QRMatrix::M_FINDER, QRMatrix::M_FINDER_DOT],

	]);
	//$options->moduleValues        = [
	//	// finder
	//	QRMatrix::M_FINDER_DARK    => [$colorSecundario], // dark (true)
	//	QRMatrix::M_FINDER_DOT     => [$colorSecundario], // finder dot, dark (true)
	//	QRMatrix::M_FINDER         => [255, 255, 255], // light (false), white is the transparency color and is enabled by default
	//	// alignment
	//	QRMatrix::M_ALIGNMENT_DARK => [$colorPrimario],
	//	QRMatrix::M_ALIGNMENT      => [255, 255, 255],
	//	// timing
	//	QRMatrix::M_TIMING_DARK    => [$colorPrimario],
	//	QRMatrix::M_TIMING         => [255, 255, 255],
	//	// format
	//	QRMatrix::M_FORMAT_DARK    => [$colorPrimario],
	//	QRMatrix::M_FORMAT         => [255, 255, 255],
	//	// version
	//	QRMatrix::M_VERSION_DARK   => [$colorPrimario],
	//	QRMatrix::M_VERSION        => [255, 255, 255],
	//	// data
	//	QRMatrix::M_DATA_DARK      => [$colorPrimario],
	//	QRMatrix::M_DATA           => [255, 255, 255],
	//	// darkmodule
	//	QRMatrix::M_DARKMODULE     => [$colorPrimario],
	//	// separator
	//	QRMatrix::M_SEPARATOR      => [255, 255, 255],
	//	// quietzone
	//	QRMatrix::M_QUIETZONE      => [255, 255, 255],
	//	// logo (requires a call to QRMatrix::setLogoSpace()), see QRImageWithLogo
	//	QRMatrix::M_LOGO           => [255, 255, 255],
	//];

	$qrcode = new QRCode($options);
	$qrcode->addByteSegment($urlSite);

	//header('Content-type: image/png');

	$qrOutputInterface = new QRImageWithLogo($options, $qrcode->getMatrix());

	// dump the output, with an additional logo
	// the logo could also be supplied via the options, see the svgWithLogo example
	// $qrOutputInterface->dump(null, 'logo.png');
	if ($nombre == '') {
		$nombre = uniqid();
	}
	$filename = 'qr_' . $nombre . '.png';

	// Ruta donde se guardará la imagen (asegúrate de que el directorio tenga permisos de escritura)
	$filepath = $directoryPath . '/' . $filename;

	// Guardar la imagen en el servidor
	file_put_contents($filepath, $qrOutputInterface->dump(null, $logo));
	return;
}

/**
 * Retrieves all QR codes for a given store and tables.
 *
 * @param clsLojas $oLojas The store object.
 * @param array $mesas An array of tables.
 * @return void
 */
function GetAllQRLoja(clsLojas $oLojas, $mesas)
{
	
	// Function implementation goes here
	$directoryPath = getLocal('QRS') . $oLojas->getId();

	// Verificar si el directorio existe
	if (!directoryExistsAndHasFiles($directoryPath)) {
		
		CreateQr(
			$oLojas->getId(),
			'https://ementarest.pt/' . $oLojas->getRuta_Ementa(),
			getLocal('logos') . $oLojas->getLogo(),
			'so ementa digital'
		);
		if ($mesas !=false) {
			foreach ($mesas as $key => $mesa) {
				CreateQr(
					$oLojas->getId(),
					'https://ementarest.pt/' . $oLojas->getRuta_Ementa() . '?mesa=' . $mesa['id'],
					getLocal('logos') . $oLojas->getLogo(),
					$mesa['identificador']
				);
			}
		}
	}
	$files = scandir($directoryPath);
	$files = array_diff($files, array('.', '..'));
	
	// Obtén la fecha de creación de los archivos y ordena por ella
	usort($files, function ($a, $b) use ($directoryPath) {
		return filectime($directoryPath . '/' . $a) - filectime($directoryPath . '/' . $b);
	});

	$files = array_values($files);

	return $files;
}
function directoryExistsAndHasFiles($directoryPath)
{
	// Verificar si el directorio existe
	if (!file_exists($directoryPath)) {
		return false;
	}

	$files = scandir($directoryPath);
	$files = array_diff($files, array('.', '..'));

	// Verificar si el directorio está vacío
	if (empty($files)) {
		return false;
	}

	return true;
}

function DeleteAllQrByLojaId($loja_id)
{
	$directoryPath = getLocal('QRS') . $loja_id;
	// Verificar si el directorio existe
	if (!directoryExistsAndHasFiles($directoryPath)) {
		return;
	}

	$files = scandir($directoryPath);
	$files = array_diff($files, array('.', '..'));

	foreach ($files as $file) {
		unlink($directoryPath . '/' . $file);
	}
}

function GeneratePdf($arrayQR, $loja_id)
{

	// Crea una instancia de TCPDF y configura las propiedades del documento
	require_once getLocal('vendor') . 'tecnickcom/tcpdf/tcpdf.php';
	$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Ementarest.pt');
	$pdf->SetTitle('QR\'s da loja');
	$pdf->SetSubject('Ementa Digital');
	$pdf->SetKeywords('QR, QR Code, Ementa Digital, Ementarest.pt');
	$pdf->SetPrintHeader(false);
	$pdf->SetPrintFooter(false);


	// Agrega una nueva página al documento
	$pdf->AddPage();

	// Define las coordenadas y dimensiones de la imagen
	$x = 10;
	$y = 10;
	$w = (190 / 3) * 1; // Aumenta la anchura un 30%
	$h = 0;
	$qrCounter = 0;

	// Itera sobre cada QR
	foreach ($arrayQR as $key => $value) {
		// Si se han impreso 3 QR, agrega una nueva línea
		if ($qrCounter % 3 == 0 && $qrCounter != 0) {
			$y += 100; // Ajusta la posición vertical para la siguiente línea
			$x = 10; // Reinicia la posición horizontal al principio de la página
		}

		// Si la posición vertical es mayor que el tamaño de la página, agrega una nueva página
		if ($y > 270) {
			$pdf->AddPage();
			$x = 10;
			$y = 10;
		}

		// Agrega la imagen al PDF
		$ruta = getLocal('QRS') . $loja_id . '/' . $value;
		$pdf->Image($ruta, $x, $y, $w, $h, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
		$nombre = explode('.', $value)[0];

		// Ajusta la posición vertical del título debajo de la imagen
		$titleY = $y + $h - 10; // Reducimos 10mm la posición Y para subir el título

		// Agrega un título debajo de la imagen
		$pdf->SetFont('helvetica', 'B', 10);
		$pdf->SetXY($x, $titleY); // Ajusta la posición del título
		$pdf->Cell($w, 0, $nombre, 0, 0, 'C', 0);

		// Incrementa el contador de QR
		$qrCounter++;

		// Ajusta la posición horizontal para el siguiente QR
		$x += (190 / 3) + 5; // Aumenta el espacio horizontal entre las imágenes
	}

	// Genera el PDF y envíalo al navegador para su descarga
	$pdf->Output('QR.pdf', 'D');
}
